<?php

namespace ShoppKe\Lib;

class Forms
{
    public function submit(string $path): array
    {
        $kind = match ($path) { '/join' => 'store', '/reach-out' => 'contact', default => 'newsletter' };
        $values = [];
        foreach (['name', 'business', 'email', 'phone', 'category', 'location', 'message', 'topic', 'consent', 'plan'] as $field) {
            $values[$field] = is_string($_POST[$field] ?? null) ? trim($_POST[$field]) : '';
        }
        $errors = [];
        $status = 422;
        if (empty($_SESSION['csrf']) || !is_string($_POST['csrf'] ?? null) || !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
            $errors['form'] = 'Your session expired. Please submit this form again.';
            $status = 403;
        }
        if (!empty($_POST['website'])) {
            $errors['form'] = 'We could not accept this request. Please try again.';
        }
        if (!filter_var($values['email'], FILTER_VALIDATE_EMAIL) || strlen($values['email']) > 254) {
            $errors['email'] = 'Enter a valid email address.';
        }
        if ($kind !== 'newsletter' && (mb_strlen($values['name']) < 2 || mb_strlen($values['name']) > 100)) {
            $errors['name'] = 'Enter your name (2 to 100 characters).';
        }
        if ($kind === 'store') {
            if (!in_array($values['plan'], ['Not sure yet', 'Starter', 'Power Seller'], true)) {
                $errors['plan'] = 'Choose one of the available plans.';
            }
            if (mb_strlen($values['business']) < 2 || mb_strlen($values['business']) > 150) {
                $errors['business'] = 'Enter your business name (2 to 150 characters).';
            }
            if (!in_array($values['category'], ['Fashion & beauty', 'Food & groceries', 'Electronics', 'Home & lifestyle', 'Other'], true)) {
                $errors['category'] = 'Choose what you sell.';
            }
            if (mb_strlen($values['location']) < 2 || mb_strlen($values['location']) > 150) {
                $errors['location'] = 'Enter your town or neighbourhood.';
            }
            if ($values['phone'] && !preg_match('/^\+?[0-9 ()-]{7,24}$/D', $values['phone'])) {
                $errors['phone'] = 'Enter a valid phone number, or leave it blank.';
            }
        }
        if ($kind === 'contact') {
            if (!in_array($values['topic'], ['Getting started', 'Plans & pricing', 'Delivery', 'Partnerships', 'Something else'], true)) {
                $errors['topic'] = 'Choose what you would like to discuss.';
            }
            if (mb_strlen($values['message']) < 15 || mb_strlen($values['message']) > 5000) {
                $errors['message'] = 'Write a message between 15 and 5,000 characters.';
            }
        }
        if ($values['consent'] !== 'yes') {
            $errors['consent'] = 'Please agree before continuing.';
        }
        if ($errors) {
            return compact('kind', 'values', 'errors', 'status') + ['success' => false];
        }

        try {
            $reference = strtoupper(bin2hex(random_bytes(5)));
            $directory = config('storage_path');
            if (!is_dir($directory) && !mkdir($directory, 0700, true) && !is_dir($directory)) {
                throw new \RuntimeException('Cannot create submission storage.');
            }
            $file = fopen($directory . '/submissions.jsonl', 'c+b');
            if (!$file || !flock($file, LOCK_EX)) {
                throw new \RuntimeException('Cannot lock submission storage.');
            }
            chmod($directory . '/submissions.jsonl', 0600);
            try {
                // Count and save under one lock so concurrent requests cannot bypass the limit.
                $client = hash('sha256', ($_SERVER['REMOTE_ADDR'] ?? 'local') . dirname(__DIR__, 2));
                $recent = 0;
                while (($line = fgets($file)) !== false) {
                    $entry = json_decode($line, true);
                    if (($entry['client'] ?? '') === $client && ($entry['timestamp'] ?? 0) > time() - 600) {
                        $recent++;
                    }
                }
                if ($recent >= 8) {
                    return compact('kind', 'values') + ['success' => false, 'status' => 429, 'errors' => ['form' => 'You have sent several requests. Please try again in ten minutes.']];
                }
                $record = ['reference' => $reference, 'kind' => $kind, 'timestamp' => time(), 'client' => $client, 'values' => $values];
                $json = json_encode($record, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES) . "\n";
                fseek($file, 0, SEEK_END);
                if (fwrite($file, $json) !== strlen($json)) {
                    throw new \RuntimeException('Cannot save submission.');
                }
                fflush($file);
            } finally {
                flock($file, LOCK_UN);
                fclose($file);
            }
            return ['success' => true, 'kind' => $kind, 'reference' => $reference];
        } catch (\Throwable $error) {
            error_log('Shopp.ke submission: ' . $error->getMessage());
            return compact('kind', 'values') + ['success' => false, 'status' => 503, 'errors' => ['form' => 'We could not save your request just now. Your details are still here; please try again.']];
        }
    }
}
