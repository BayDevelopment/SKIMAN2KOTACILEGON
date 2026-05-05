<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login', [
            'title' => 'PEMBELAJARAN DIGITAL MAN 2 KOTA CILEGON | YAKUB'
        ]);
    }

    public function authenticate(Request $request)
    {
        // ✅ Validasi - HAPUS exists:users,email agar tidak bocor info
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'email.required'    => 'Email wajib diisi',
            'email.email'       => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
            'password.min'      => 'Password minimal 6 karakter',
        ]);

        // 🛡️ Rate Limiting - max 5 percobaan per menit per IP+email
        $key = 'login.' . Str::lower($request->email) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'email' => "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik.",
            ])->onlyInput('email');
        }

        // 🔐 Proses Login
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            RateLimiter::clear($key);
            $request->session()->regenerate();

            $user = Auth::user();

            // ✅ Redirect berdasarkan role
            if ($user->isAdmin()) {
                return redirect()->intended('/admin/dashboard')
                    ->with('success', 'Login berhasil');
            }

            if ($user->isSiswa()) {
                return redirect()->intended('/siswa/dashboard')
                    ->with('success', 'Login berhasil');
            }

            // Role tidak dikenal → logout paksa
            Auth::logout();
            return redirect('/login')->withErrors(['email' => 'Akun tidak memiliki akses.']);
        }

        // ❌ Login gagal - increment rate limiter
        RateLimiter::hit($key);

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Berhasil logout');
    }
}
