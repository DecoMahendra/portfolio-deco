<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/*
  Alur login Laravel, tanpa library tambahan:
  1. show()   — tampilkan form
  2. login()  — cocokkan email + password dengan tabel users
  3. logout() — hapus session

  Password di tabel users tersimpan dalam bentuk hash (acak satu arah),
  Auth::attempt yang membandingkannya — kita tidak pernah menyentuh
  password aslinya.
*/
class LoginController extends Controller
{
    public function show(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials)) {
            // Pesan sengaja tidak membedakan "email tidak ada" dan "password salah",
            // supaya tidak membocorkan email mana yang terdaftar.
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Email atau password salah.']);
        }

        // ID session diganti setelah login: pengaman terhadap session fixation.
        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
