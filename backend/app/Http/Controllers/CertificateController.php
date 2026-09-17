<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Services\Cloudinary;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

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

        /*
          Tiga kemungkinan dari form:
          - ada file baru      : hapus gambar lama (kalau ada), unggah yang baru
          - centang "hapus"    : hapus gambar lama, kosongkan kolomnya
          - tidak keduanya     : gambar tidak disentuh
        */
        if ($request->hasFile('image') || $request->boolean('remove_image')) {
            if ($certificate->image_public_id) {
                $cloudinary->delete($certificate->image_public_id);
            }

            $data += $request->hasFile('image')
                ? $this->uploaded($cloudinary, $request)
                : ['image_url' => null, 'image_public_id' => null];
        }

        $certificate->updateAtPosition($data);

        return redirect()->route('admin.certificates.index')->with('status', 'Sertifikat disimpan.');
    }

    public function destroy(Certificate $certificate, Cloudinary $cloudinary): RedirectResponse
    {
        if ($certificate->image_public_id) {
            $cloudinary->delete($certificate->image_public_id);
        }

        $certificate->deleteAndCloseGap();

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
