<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'PEMBELAJARAN DIGITAL MAN 2 KOTA CILEGON | YAKUB'
        ];

        return view('auth.login', $data);
    }

    public function authenticate(Request $request)
    {
        // ✅ VALIDASI KUAT
        $credentials = $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.exists' => 'Email tidak terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        // 🔐 PROSES LOGIN
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/siswa/dashboard')
                ->with('success', 'Login berhasil');
        }

        // ❌ jika password salah
        return back()->withErrors([
            'password' => 'Password atau Email salah!',
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
