<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman (form) login
    public function showLoginForm()
    {
        return view('admin.login');
    }

    // Memproses data (email & password) yang dikirim dari form login
    public function login(Request $request)
    {
        // 1. Validasi Input: Pastikan username & password tidak kosong
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        // 2. Cek ke Database: Apakah username dan password cocok?
        if (Auth::attempt($credentials)) {
            // Jika cocok, buatkan sesi baru (session) untuk keamanan
            $request->session()->regenerate();

            // Arahkan admin yang berhasil login ke halaman dashboard
            return redirect()->intended('/admin');
        }

        // 3. Jika gagal: Kembalikan ke halaman login dan bawa pesan error
        return back()->withErrors([
            'username' => 'Username atau password yang Anda masukkan salah.',
        ])->onlyInput('username'); // Tetap pertahankan isian username
    }

    // Mengurus proses keluar (Logout)
    public function logout(Request $request)
    {
        // Hapus status login
        Auth::logout();

        // Hancurkan tiket sesi (session)
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Arahkan kembali ke halaman depan atau halaman login
        return redirect('/login');
    }
}
