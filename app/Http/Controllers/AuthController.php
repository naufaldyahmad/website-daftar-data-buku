<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Menampilkan formulir login admin.
     */
    public function tampilkanLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('buku.index');
        }

        return view('auth.login');
    }

    /**
     * Memproses permintaan login admin.
     */
    public function login(Request $request): RedirectResponse
    {
        $kredensial = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $ingatSaya = $request->boolean('remember');

        if (Auth::attempt($kredensial, $ingatSaya)) {
            $request->session()->regenerate();

            return redirect()->intended(route('buku.index'))
                ->with('sukses', 'Selamat datang kembali, '.Auth::user()->name.'!');
        }

        return back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => 'Email atau kata sandi yang Anda masukkan salah.',
            ]);
    }

    /**
     * Memproses logout admin.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('buku.index')
            ->with('sukses', 'Anda telah berhasil keluar (logout).');
    }
}
