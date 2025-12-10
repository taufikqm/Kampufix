<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (Auth::check()) {
            $user = Auth::user();
            // arahkan sesuai role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            if ($user->role === 'teknisi') {
                return redirect()->route('teknisi.dashboard');
            }
            return redirect()->route('mahasiswa.dashboard');
        }

        return $next($request);
    }
}
