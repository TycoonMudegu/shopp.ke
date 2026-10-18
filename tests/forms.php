<?php

$directory = sys_get_temp_dir() . '/shopp-ke-unit-' . bin2hex(random_bytes(6));
putenv('SHOPP_STORAGE_PATH=' . $directory);
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../site/helpers.php';

function check(bool $condition, string $message): void
{
    if (!$condition) {
        throw new RuntimeException($message);
    }
    echo "PASS $message\n";
}

$forms = new ShoppKe\Lib\Forms();
$token = bin2hex(random_bytes(32));
$valid = ['csrf' => $token, 'email' => 'test@example.invalid', 'consent' => 'yes'];
$_SESSION = [];
$_POST = $valid;
check($forms->submit('/subscribe')['status'] === 403, 'Missing session cannot bypass CSRF');

$_SESSION['csrf'] = $token;
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
$_POST = $valid + ['website' => 'spam'];
check($forms->submit('/subscribe')['status'] === 422, 'Honeypot rejects bot submission');
$_POST = array_replace($valid, ['email' => 'bad']);
check(isset($forms->submit('/subscribe')['errors']['email']), 'Invalid email is rejected');
$_POST = array_replace($valid, ['consent' => '']);
check(isset($forms->submit('/subscribe')['errors']['consent']), 'Consent is required');

try {
    $_POST = $valid;
    $result = $forms->submit('/subscribe');
    check($result['success'], 'Valid newsletter subscription is saved');
    $record = json_decode(trim(file_get_contents($directory . '/submissions.jsonl')), true, 512, JSON_THROW_ON_ERROR);
    check($record['reference'] === $result['reference'] && $record['values']['email'] === $valid['email'], 'Saved data matches the confirmation reference');
    check((fileperms($directory . '/submissions.jsonl') & 0777) === 0600, 'Submission file is private');
    check((fileperms($directory) & 0777) === 0700, 'Storage directory is private');

    $_POST = $valid + ['name' => 'QA Person', 'business' => 'QA Store', 'location' => 'Nairobi', 'category' => 'Electronics', 'plan' => 'Starter'];
    check($forms->submit('/join')['success'], 'Store request is saved');
    $_POST = $valid + ['name' => 'QA Person', 'topic' => 'Getting started', 'message' => 'A sufficiently detailed contact message.'];
    check($forms->submit('/reach-out')['success'], 'Contact enquiry is saved');
    $_POST = $valid;
    for ($i = 0; $i < 5; $i++) {
        check($forms->submit('/subscribe')['success'], 'Request within rate limit is accepted');
    }
    check($forms->submit('/subscribe')['status'] === 429, 'Repeated requests are rate limited');
    check(count(file($directory . '/submissions.jsonl')) === 8, 'Rejected requests do not append records');
} finally {
    if (is_file($directory . '/submissions.jsonl')) {
        unlink($directory . '/submissions.jsonl');
    }
    if (is_dir($directory)) {
        rmdir($directory);
    }
}
