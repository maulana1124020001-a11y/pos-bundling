<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // tampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // proses login
    public function login(Request $request)
    {
        // validasi
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // cek remember me
        $remember = $request->has('remember');

        // proses login
        if (Auth::attempt($credentials, $remember)) {

            // regenerasi session (security)
            $request->session()->regenerate();

            // ambil user login
            $user = Auth::user();

            // redirect berdasarkan role
            if ($user->role_id == 1) {
                return redirect()->intended(route('transaksi.index'));
            }

            return redirect()->intended('/transaksi/create');
        }

        // kalau gagal login
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    // logout
    public function logout(Request $request)
    {
        Auth::logout();

        // penting untuk keamanan
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}