<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserActive
{
    /**
     * Pastikan user yang sedang login masih aktif (is_active = true).
     * Kalau superadmin nonaktifkan user di tengah sesi, dia akan
     * di-force-logout di request berikutnya — bukan menunggu logout manual.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && ! Auth::user()->is_active) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('auth.login')
                ->withErrors(['login' => 'Akun Anda telah dinonaktifkan. Hubungi superadmin.']);
        }

        return $next($request);
    }
}