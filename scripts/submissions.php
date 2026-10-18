<?php

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

require __DIR__ . '/../site/helpers.php';
$file = config('storage_path') . '/submissions.jsonl';
if (!is_readable($file)) {
    fwrite(STDERR, "Submission storage is empty or not readable by this user.\n");
    exit(1);
}

$stream = fopen($file, 'rb');
flock($stream, LOCK_SH);
try {
    while (($line = fgets($stream)) !== false) {
        $record = json_decode($line, true, 512, JSON_THROW_ON_ERROR);
        unset($record['client']);
        echo json_encode($record, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR) . "\n";
    }
} finally {
    flock($stream, LOCK_UN);
    fclose($stream);
}
