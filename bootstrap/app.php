<?php

// Polyfill mb_strimwidth jika ekstensi mbstring belum aktif di PHP server
if (!function_exists('mb_strimwidth')) {
    function mb_strimwidth(?string $string, int $start, int $width, string $trim_marker = '', ?string $encoding = null): string
    {
        $string = (string) $string;
        $markerWidth = function_exists('mb_strwidth') ? mb_strwidth($trim_marker, $encoding) : strlen($trim_marker);
        if ($width < $markerWidth) {
            return $trim_marker;
        }

        $targetWidth = $width - $markerWidth;

        if (function_exists('mb_substr') && function_exists('mb_strwidth')) {
            $result = '';
            $currentWidth = 0;
            $len = function_exists('mb_strlen') ? mb_strlen($string, $encoding) : strlen($string);
            for ($i = $start; $i < $len; $i++) {
                $char = mb_substr($string, $i, 1, $encoding);
                $charWidth = mb_strwidth($char, $encoding);
                if ($currentWidth + $charWidth > $targetWidth) {
                    break;
                }
                $result .= $char;
                $currentWidth += $charWidth;
            }
            return $result . $trim_marker;
        }

        $sub = substr($string, $start, $targetWidth);
        return $sub . $trim_marker;
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
