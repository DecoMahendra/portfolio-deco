<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/*
  Profil hanya satu baris, jadi tidak ada daftar, tambah, atau hapus —
  cukup edit() untuk menampilkan form dan update() untuk menyimpannya.

  Dipakai firstOrNew, bukan firstOrFail: di database yang masih kosong barisnya
  belum ada. Dengan firstOrFail halamannya menjadi 404, jadi profil tidak akan
  pernah bisa diisi lewat dashboard. firstOrNew memberi objek kosong yang belum
  tersimpan, sehingga formnya tetap terbuka dan isian pertama bisa disimpan.
*/
class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('admin.profile.edit', ['profile' => Profile::firstOrNew()]);
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

        // fill + save: satu jalur untuk dua keadaan — membuat baris pertama
        // kalau belum ada, memperbarui kalau sudah ada.
        Profile::firstOrNew()->fill($data)->save();

        return redirect()->route('admin.profile.edit')->with('status', 'Profil disimpan.');
    }
}
