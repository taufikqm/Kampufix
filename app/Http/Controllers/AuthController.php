<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginPage()
    {
        if (Auth::check()) {
            return $this->redirectByRole();
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return $this->redirectByRole();
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    private function redirectByRole()
    {
        $user = Auth::user();

        // Debug: cek role user
        \Log::info('User role check', [
            'user_id' => $user->id,
            'email' => $user->email,
            'role' => $user->role,
            'role_type' => gettype($user->role),
            'isAdmin' => $user->isAdmin(),
            'isTeknisi' => $user->isTeknisi(),
            'isMahasiswa' => $user->isMahasiswa(),
        ]);

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->isTeknisi()) {
            return redirect()->route('teknisi.dashboard');
        }

        return redirect()->route('mahasiswa.dashboard');
    }
}
