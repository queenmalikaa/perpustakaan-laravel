<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Kalau belum login, redirect ke login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $userRole = auth()->user()->role;

        // Kalau role cocok, lanjutkan
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // Kalau role tidak cocok, redirect ke dashboard yang sesuai
        if ($userRole === 'admin') {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }
        if ($userRole === 'petugas') {
            return redirect()->route('petugas.dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }
        if ($userRole === 'user') {
            return redirect()->route('user.dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        // Fallback
        return redirect()->route('login');
    }
}