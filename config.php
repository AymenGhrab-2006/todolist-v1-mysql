<?php
/**
 * Minimal .env loader — no Composer/vlucas dependency needed.
 * Reads KEY=VALUE pairs from .env in this same folder and exposes
 * them as constants. If .env is missing, sane local defaults are used.
 */
function loadEnv(string $path): void
{
    if (!file_exists($path)) {
        return;
    }
    foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
            continue;
        }
        [$key, $value] = array_map('trim', explode('=', $line, 2));
        $value = trim($value, "\"'"); // strip optional surrounding quotes
        if (getenv($key) === false) {
            putenv("$key=$value");
        }
    }
}

loadEnv('.env');

define('DB_HOST', getenv('DB_HOST') ?: '127.0.0.1');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'bdtask');
