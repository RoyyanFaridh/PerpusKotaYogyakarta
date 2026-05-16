<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HasPermission
{
    public function handle(Request $request, Closure $next, string $permission)
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('auth.login');
        }

        if (!$user->hasPermission($permission)) {
            return redirect()->back()->with('permission_denied', 'Anda tidak memiliki izin untuk melakukan aksi ini.');
        }

        return $next($request);
    }
}