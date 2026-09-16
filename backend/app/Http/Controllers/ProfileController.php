<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/*
  Profil hanya satu baris, jadi tidak ada daftar, tambah, atau hapus —
  cukup edit() untuk menampilkan form dan update() untuk menyimpannya.
*/
class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('admin.profile.edit', ['profile' => Profile::firstOrFail()]);
    }

    public function update(Request $request): RedirectResponse
    {
        /*
          Validasi di server WAJIB walau form browser sudah punya "required":
          pengaturan browser bisa dilewati, aturan di sini tidak.
          Batas 255 mengikuti tipe kolom string di migration.
        */
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'availability' => ['required', 'string', 'max:255'],
            'tagline' => ['required', 'string'],
            'bio' => ['required', 'string'],
            'photo_alt' => ['required', 'string', 'max:255'],
        ]);

        Profile::firstOrFail()->update($data);

        return redirect()->route('admin.profile.edit')->with('status', 'Profil disimpan.');
    }
}
