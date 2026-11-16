<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$_ENV['VERCEL'] = '1';
$_SERVER['VERCEL'] = '1';
putenv('VERCEL=1');

// Cache & Storage redirection to writable /tmp
putenv('APP_CONFIG_CACHE=/tmp/config.php');
putenv('APP_EVENTS_CACHE=/tmp/events.php');
putenv('APP_PACKAGES_CACHE=/tmp/packages.php');
putenv('APP_ROUTES_CACHE=/tmp/routes.php');
putenv('APP_SERVICES_CACHE=/tmp/services.php');
putenv('VIEW_COMPILED_PATH=/tmp');
putenv('LOG_CHANNEL=stderr');
putenv('CACHE_DRIVER=array');
putenv('SESSION_DRIVER=cookie');

if (!getenv('APP_KEY')) {
    putenv('APP_KEY=base64:9cYIj+3C8PdHpQGFsOHL+4euQAjWPF+VCZ8HwdDdd5E=');
    $_ENV['APP_KEY'] = 'base64:9cYIj+3C8PdHpQGFsOHL+4euQAjWPF+VCZ8HwdDdd5E=';
    $_SERVER['APP_KEY'] = 'base64:9cYIj+3C8PdHpQGFsOHL+4euQAjWPF+VCZ8HwdDdd5E=';
}

$dirs = [
    '/tmp/storage',
    '/tmp/storage/framework',
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
    '/tmp/storage/app',
    '/tmp/storage/app/public'
];
foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

require __DIR__ . '/../public/index.php';
