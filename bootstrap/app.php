<?php

// Polyfill fungsi mbstring jika ekstensi mbstring belum aktif di PHP server
if (!function_exists('mb_strlen')) {
    function mb_strlen(?string $string, ?string $encoding = null): int
    {
        return strlen((string) $string);
    }
}

if (!function_exists('mb_substr')) {
    function mb_substr(?string $string, int $start, ?int $length = null, ?string $encoding = null): string
    {
        $string = (string) $string;
        return $length === null ? substr($string, $start) : substr($string, $start, $length);
    }
}

if (!function_exists('mb_strwidth')) {
    function mb_strwidth(?string $string, ?string $encoding = null): int
    {
        return strlen((string) $string);
    }
}

if (!function_exists('mb_strimwidth')) {
    function mb_strimwidth(?string $string, int $start, int $width, string $trim_marker = '', ?string $encoding = null): string
    {
        $string = (string) $string;
        $markerWidth = mb_strwidth($trim_marker, $encoding);
        if ($width < $markerWidth) {
            return $trim_marker;
        }

        $targetWidth = $width - $markerWidth;
        $sub = substr($string, $start, $targetWidth);
        return $sub . $trim_marker;
    }
}

// Helper cerdas URL file upload (menghindari double 'uploads/uploads/')
if (!function_exists('storage_upload_url')) {
    function storage_upload_url(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        $cleanPath = ltrim($path, '/');
        // Bersihkan jika ada duplikasi uploads/uploads/
        while (str_starts_with($cleanPath, 'uploads/uploads/')) {
            $cleanPath = substr($cleanPath, 8);
        }

        if (!str_starts_with($cleanPath, 'uploads/')) {
            $cleanPath = 'uploads/' . $cleanPath;
        }

        return asset('storage/' . $cleanPath);
    }
}

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'permission' => \App\Http\Middleware\PermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();

if (isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL']) || getenv('VERCEL')) {
    $app->useStoragePath('/tmp/storage');
}

return $app;
