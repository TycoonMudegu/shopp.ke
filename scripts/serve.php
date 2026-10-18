<?php

$public = realpath(__DIR__ . '/../public');
$path = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/');
$file = realpath($public . $path);
if ($file && str_starts_with($file, $public . DIRECTORY_SEPARATOR) && is_file($file) && pathinfo($file, PATHINFO_EXTENSION) !== 'php') {
    return false;
}
$_SERVER['SCRIPT_NAME'] = '/index.php';
require $public . '/index.php';
