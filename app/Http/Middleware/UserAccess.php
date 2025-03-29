<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$userRoles): Response
    {
        // Izinkan akses ke route notifikasi tanpa memeriksa role
        if ($request->routeIs('notifications.markAsRead')) {
            return $next($request);
        }

        // Pastikan $userRoles adalah array
        $allowedRoles = is_array($userRoles) ? $userRoles : [$userRoles];

        // Periksa apakah role user termasuk dalam daftar role yang diizinkan
        if (in_array(auth()->user()->role, $allowedRoles)) {
            return $next($request);
        }

        // Redirect ke halaman home dengan pesan error
        return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}