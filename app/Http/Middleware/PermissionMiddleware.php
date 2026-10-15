<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = $request->user();

        if (!$user) {
            abort(403, 'Unauthorized.');
        }

        if ($user->role === 'superadmin') {
            return $next($request);
        }

        if (!$user->hasPermission($permission)) {
            abort(403, 'Anda tidak memiliki hak akses untuk membuka halaman atau mengelola modul ini.');
        }

        return $next($request);
    }
}
