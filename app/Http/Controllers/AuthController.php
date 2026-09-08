<?php

namespace App\Http\Controllers;

use App\Services\ActivityLogger;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (\Illuminate\Support\Facades\Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (\Illuminate\Support\Facades\Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();
            $user = \Illuminate\Support\Facades\Auth::user();

            ActivityLogger::log(
                action: 'login',
                description: "Pengguna {$user->name} ({$user->email}) berhasil login ke sistem.",
                subject: $user,
                module: 'Autentikasi',
                properties: [
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ],
                user: $user
            );

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        if ($user) {
            ActivityLogger::log(
                action: 'logout',
                description: "Pengguna {$user->name} ({$user->email}) logout dari sistem.",
                subject: $user,
                module: 'Autentikasi',
                properties: [
                    'ip' => $request->ip(),
                ],
                user: $user
            );
        }

        \Illuminate\Support\Facades\Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
