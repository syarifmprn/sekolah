<?php

// Pastikan direktori storage di /tmp tersedia untuk lingkungan serverless Vercel
$storagePath = '/tmp/storage';
$subdirs = [
    '/framework/views',
    '/framework/cache/data',
    '/framework/sessions',
    '/logs',
];

foreach ($subdirs as $subdir) {
    $path = $storagePath . $subdir;
    if (!is_dir($path)) {
        mkdir($path, 0755, true);
    }
}

// Teruskan request ke entrypoint Laravel di public/index.php
require __DIR__ . '/../public/index.php';
