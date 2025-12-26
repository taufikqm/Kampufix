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

        // Debug: Log credentials (jangan log password di production!)
        \Log::info('Login attempt', [
            'email' => $credentials['email'],
            'has_password' => !empty($credentials['password'])
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Debug: Log successful auth
            \Log::info('Auth successful', [
                'user_id' => Auth::id(),
                'user_role' => Auth::user()->role
            ]);
            
            return $this->redirectByRole();
        }

        // Debug: Log failed auth
        \Log::warning('Auth failed', [
            'email' => $credentials['email']
        ]);

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
