<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Services\Cloudinary;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

/*
  Pola yang sama dengan ExperienceController, ditambah satu gambar opsional
  yang disimpan di Cloudinary (lihat App\Services\Cloudinary).
*/
class CertificateController extends Controller
{
    public function index(): View
    {
        return view('admin.certificates.index', [
            'certificates' => Certificate::orderBy('sort_order')->get(),
        ]);
    }

    public function create(): View
    {
        // Posisi bawaan untuk data baru: paling akhir.
        return view('admin.certificates.create', ['nextPosition' => Certificate::count() + 1]);
    }

    public function store(Request $request, Cloudinary $cloudinary): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            $data += $this->uploaded($cloudinary, $request);
        }

        Certificate::createAtPosition($data);

        return redirect()->route('admin.certificates.index')->with('status', 'Sertifikat ditambahkan.');
    }

    public function edit(Certificate $certificate): View
    {
        return view('admin.certificates.edit', ['certificate' => $certificate]);
    }

    public function update(Request $request, Certificate $certificate, Cloudinary $cloudinary): RedirectResponse
    {
        $data = $this->validated($request);
        $oldImageId = $certificate->image_public_id;
        $uploaded = null;

        /*
          Tiga kemungkinan dari form:
          - ada file baru      : unggah yang baru, gambar lama dihapus SETELAH tersimpan
          - centang "hapus"    : kosongkan kolomnya, gambar lama dihapus SETELAH tersimpan
          - tidak keduanya     : gambar tidak disentuh

          Gambar lama sengaja dihapus paling akhir. Kalau dihapus duluan lalu
          langkah berikutnya gagal, database masih menunjuk ke gambar yang sudah
          tidak ada, dan website menampilkan gambar rusak.
        */
        $isReplacingImage = $request->hasFile('image') || $request->boolean('remove_image');

        if ($request->hasFile('image')) {
            $uploaded = $this->uploaded($cloudinary, $request);
            $data += $uploaded;
        } elseif ($request->boolean('remove_image')) {
            $data += ['image_url' => null, 'image_public_id' => null];
        }

        try {
            $certificate->updateAtPosition($data);
        } catch (Throwable $e) {
            // Simpan gagal: gambar yang barusan terunggah tidak dipakai siapa pun — hapus lagi.
            if ($uploaded) {
                $cloudinary->delete($uploaded['image_public_id']);
            }

            throw $e;
        }

        if ($isReplacingImage && $oldImageId) {
            $cloudinary->delete($oldImageId);
        }

        return redirect()->route('admin.certificates.index')->with('status', 'Sertifikat disimpan.');
    }

    public function destroy(Certificate $certificate, Cloudinary $cloudinary): RedirectResponse
    {
        // Database dulu, baru gambarnya. Kalau dibalik dan menghapus barisnya gagal,
        // sertifikat masih tampil tapi gambarnya sudah hilang dari Cloudinary.
        $certificate->deleteAndCloseGap();

        if ($certificate->image_public_id) {
            $cloudinary->delete($certificate->image_public_id);
        }

        return redirect()->route('admin.certificates.index')->with('status', 'Sertifikat dihapus.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'organizer' => ['required', 'string', 'max:255'],
            'year' => ['required', 'string', 'max:255'],
            // Opsional. max dalam KB: 5120 = 5 MB.
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            // position (mulai dari 1) diterjemahkan ke sort_order oleh trait HasSortOrder.
            'position' => ['required', 'integer', 'min:1'],
        ]);

        // File-nya sendiri bukan kolom tabel, jadi dikeluarkan dari data yang disimpan.
        unset($data['image']);

        return $data;
    }

    /** @return array{image_url: string, image_public_id: string} */
    private function uploaded(Cloudinary $cloudinary, Request $request): array
    {
        $uploaded = $cloudinary->upload($request->file('image'), 'portfolio/certificates');

        return ['image_url' => $uploaded['url'], 'image_public_id' => $uploaded['public_id']];
    }
}
