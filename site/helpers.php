<?php

function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function config(string $key, $default = '')
{
    static $settings;
    $settings ??= require __DIR__ . '/../config/site.php';
    return $settings[$key] ?? $default;
}

function icon(string $name, string $class = ''): string
{
    return '<svg class="icon ' . e($class) . '" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><use href="/assets/icons.svg#' . e($name) . '"></use></svg>';
}

function csrf_token(): string
{
    $_SESSION['csrf'] ??= bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}

function asset(string $path): string
{
    $file = __DIR__ . '/../public' . $path;
    return $path . '?v=' . filemtime($file);
}

function form_value(string $key, string $default = ''): string
{
    return e($GLOBALS['form']['values'][$key] ?? $default);
}

function field_error(string $key): string
{
    $error = $GLOBALS['form']['errors'][$key] ?? '';
    return $error ? '<span class="field-error" id="error-' . e($key) . '">' . e($error) . '</span>' : '';
}

function field_state(string $key): string
{
    return isset($GLOBALS['form']['errors'][$key]) ? ' aria-invalid="true" aria-describedby="error-' . e($key) . '"' : '';
}

function form_hidden(string $kind): void
{
    echo '<input type="hidden" name="csrf" value="' . e(csrf_token()) . '">';
    echo '<input type="hidden" name="kind" value="' . e($kind) . '">';
    echo '<div class="form-trap" aria-hidden="true"><label>Website<input name="website" type="text" tabindex="-1" autocomplete="off"></label></div>';
}

function app_url(string $path): string
{
    if (!in_array($path, ['/login', '/register'], true)) { throw new InvalidArgumentException('Unsupported account destination.'); }
    return rtrim(config('app_url'), '/') . $path;
}
