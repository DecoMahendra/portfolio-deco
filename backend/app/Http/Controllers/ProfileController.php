<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Services\Cloudinary;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

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

    public function update(Request $request, Cloudinary $cloudinary): RedirectResponse
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
            // Opsional. max dalam KB: 5120 = 5 MB.
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        // File-nya sendiri bukan kolom tabel, jadi dikeluarkan dari data yang disimpan.
        unset($data['photo']);

        $profile = Profile::firstOrNew();
        $oldPhotoId = $profile->photo_public_id;
        $uploaded = null;

        /*
          Urutannya sengaja: unggah foto baru -> simpan -> BARU hapus foto lama.
          Kalau dibalik (hapus lama dulu) dan unggahnya gagal, database masih
          menunjuk ke foto yang sudah terhapus, dan website menampilkan gambar
          rusak. Dengan urutan ini, gagal di langkah mana pun tidak merusak
          foto yang sedang tampil.
        */
        if ($request->hasFile('photo')) {
            $uploaded = $cloudinary->upload($request->file('photo'), 'portfolio/profile');
            $data += ['photo_url' => $uploaded['url'], 'photo_public_id' => $uploaded['public_id']];
        }

        try {
            // fill + save: satu jalur untuk dua keadaan — membuat baris pertama
            // kalau belum ada, memperbarui kalau sudah ada.
            $profile->fill($data)->save();
        } catch (Throwable $e) {
            // Simpan gagal: foto yang barusan terunggah tidak dipakai siapa pun.
            // Hapus lagi supaya tidak menumpuk di Cloudinary, lalu teruskan errornya.
            if ($uploaded) {
                $cloudinary->delete($uploaded['public_id']);
            }

            throw $e;
        }

        if ($uploaded && $oldPhotoId) {
            $cloudinary->delete($oldPhotoId);
        }

        return redirect()->route('admin.profile.edit')->with('status', 'Profil disimpan.');
    }
}
