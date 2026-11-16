<?php

// 1. Mark as Vercel serverless environment
$_ENV['VERCEL'] = '1';
$_SERVER['VERCEL'] = '1';
putenv('VERCEL=1');

// 2. Fallback APP_KEY so missing env variable never crashes
if (!getenv('APP_KEY')) {
    putenv('APP_KEY=base64:9cYIj+3C8PdHpQGFsOHL+4euQAjWPF+VCZ8HwdDdd5E=');
    $_ENV['APP_KEY'] = 'base64:9cYIj+3C8PdHpQGFsOHL+4euQAjWPF+VCZ8HwdDdd5E=';
    $_SERVER['APP_KEY'] = 'base64:9cYIj+3C8PdHpQGFsOHL+4euQAjWPF+VCZ8HwdDdd5E=';
}

// 3. Fallback driver settings for serverless
if (!getenv('SESSION_DRIVER') || getenv('SESSION_DRIVER') === 'database') {
    putenv('SESSION_DRIVER=cookie');
    $_ENV['SESSION_DRIVER'] = 'cookie';
}

if (!getenv('CACHE_STORE') || getenv('CACHE_STORE') === 'database') {
    putenv('CACHE_STORE=array');
    $_ENV['CACHE_STORE'] = 'array';
}

// 4. Set storage & view paths to writable /tmp
putenv('VIEW_COMPILED_PATH=/tmp/storage/framework/views');
$_ENV['VIEW_COMPILED_PATH'] = '/tmp/storage/framework/views';

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

// 5. Forward request to Laravel public/index.php
require __DIR__ . '/../public/index.php';
