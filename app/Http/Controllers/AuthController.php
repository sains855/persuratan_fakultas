<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        $title = "Login";

        return view('frontend.auth.index', compact('title'));
    }

    public function authLogin(Request $request)
{
    $credentials = $request->validate([
        'username' => ['required'],
        'password' => ['required'],
    ]);

    // Coba lakukan proses login
    if (Auth::attempt($credentials)) {
        // Jika berhasil, jangan redirect. Tapi kirim respons JSON.
        $request->session()->regenerate();

        $user = Auth::user(); // Ambil data user yang sedang login

        // Kirim jawaban JSON yang menandakan sukses, beserta ID user
        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
            ]
        ]);
    }

    // Jika gagal, kirim jawaban JSON yang menandakan error
    return response()->json([
        'success' => false,
        'message' => 'Username atau password yang Anda masukkan salah.'
    ], 401); // Kode 401 berarti "Unauthorized"
}

    public function authLogout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
