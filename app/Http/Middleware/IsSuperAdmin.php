<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsSuperAdmin
{
    public function handle(Request $request, Closure $next)
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (!$user || !$user->isSuperAdmin()) {
            return redirect()->route('admin.dashboard')
                            ->with('permission_denied', 'Akses ditolak. Hanya superadmin yang diizinkan.');
        }

        return $next($request);
    }
}