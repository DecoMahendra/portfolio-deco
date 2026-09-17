<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectImage;
use App\Services\Cloudinary;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/*
  Pola yang sama dengan ExperienceController, ditambah:
  - kolom tech (teks koma <-> array JSON)
  - slug untuk alamat halaman di frontend
  - gambar (slide) yang disimpan di Cloudinary — satu tombol Simpan mengurus
    teks project, alt/urutan gambar lama, dan unggahan gambar baru sekaligus.
    Menghapus gambar ada di ProjectImageController.
*/
class ProjectController extends Controller
{
    public function index(): View
    {
        return view('admin.projects.index', [
            'projects' => Project::orderBy('sort_order')->get(),
        ]);
    }

    public function create(): View
    {
        // Posisi bawaan untuk data baru: paling akhir.
        return view('admin.projects.create', ['nextPosition' => Project::count() + 1]);
    }

    public function store(Request $request, Cloudinary $cloudinary): RedirectResponse
    {
        $data = $this->validated($request);
        $newImages = Arr::pull($data, 'new_images', []);

        $project = Project::createAtPosition($data);
        $this->uploadImages($project, $newImages, $cloudinary);

        return redirect()->route('admin.projects.index')->with('status', 'Project ditambahkan.');
    }

    public function edit(Project $project): View
    {
        return view('admin.projects.edit', ['project' => $project]);
    }

    public function update(Request $request, Project $project, Cloudinary $cloudinary): RedirectResponse
    {
        $data = $this->validated($request, $project);
        $imagesMeta = Arr::pull($data, 'images_meta', []);
        $newImages = Arr::pull($data, 'new_images', []);

        $project->updateAtPosition($data);
        $this->updateImagesMeta($project, $imagesMeta);
        $this->uploadImages($project, $newImages, $cloudinary);

        return redirect()->route('admin.projects.index')->with('status', 'Project disimpan.');
    }

    public function destroy(Project $project, Cloudinary $cloudinary): RedirectResponse
    {
        // Baris di tabel project_images ikut terhapus oleh database (cascade),
        // tapi file di Cloudinary harus dihapus sendiri satu per satu.
        foreach ($project->images as $image) {
            $cloudinary->delete($image->public_id);
        }

        $project->deleteAndCloseGap();

        return redirect()->route('admin.projects.index')->with('status', 'Project dihapus.');
    }

    private function validated(Request $request, ?Project $current = null): array
    {
        /*
          Slug = nama versi alamat web, dipakai frontend untuk /projects/{slug}.
          Boleh dikosongkan di form: dibuat otomatis dari nama. Kalau diisi,
          tetap dirapikan (huruf kecil, spasi jadi tanda hubung) sebelum divalidasi.
        */
        $request->merge(['slug' => Str::slug($request->input('slug') ?: $request->input('name'))]);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('projects', 'slug')->ignore($current)],
            'description' => ['required', 'string'],
            'tech' => ['required', 'string'],
            // nullable: boleh kosong. Kalau diisi, harus URL yang valid.
            'repo_url' => ['nullable', 'url', 'max:255'],
            'demo_url' => ['nullable', 'url', 'max:255'],
            // position (mulai dari 1) diterjemahkan ke sort_order oleh trait HasSortOrder.
            'position' => ['required', 'integer', 'min:1'],

            // Gambar lama: images_meta[<id>][alt] dan images_meta[<id>][position].
            'images_meta' => ['nullable', 'array'],
            'images_meta.*.alt' => ['nullable', 'string', 'max:255'],
            'images_meta.*.position' => ['required', 'integer', 'min:1'],

            // Gambar baru: bisa beberapa sekaligus. max dalam KB: 5120 = 5 MB.
            'new_images' => ['nullable', 'array'],
            'new_images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ], [], [
            // Nama field di pesan error, supaya bukan "new_images.0".
            'new_images.*' => 'gambar',
            'images_meta.*.alt' => 'teks alternatif',
            'images_meta.*.position' => 'urutan gambar',
        ]);

        /*
          Di form, tech diketik sebagai teks "React, Vite, Tailwind CSS".
          Di database disimpan sebagai array JSON ["React","Vite","Tailwind CSS"]
          (lihat $casts di model Project). Di sini teksnya dipecah per koma,
          spasi di pinggir dibuang, dan bagian kosong (misal koma ganda) dibuang.
        */
        $data['tech'] = array_values(array_filter(
            array_map('trim', explode(',', $data['tech']))
        ));

        return $data;
    }

    /*
      Simpan alt + urutan gambar lama. Urutan yang diminta pengguna diurutkan,
      lalu diberi nomor ulang 0,1,2,... — lebih sederhana daripada memindahkan
      satu per satu, dan hasilnya pasti rapat tanpa nomor kembar.
      Hanya gambar milik project ini yang disentuh (whereKey di dalam relasi).
    */
    private function updateImagesMeta(Project $project, array $imagesMeta): void
    {
        $index = 0;
        foreach (collect($imagesMeta)->sortBy('position') as $id => $meta) {
            $project->images()->whereKey($id)->update([
                'alt' => $meta['alt'] ?? null,
                'sort_order' => $index++,
            ]);
        }
    }

    private function uploadImages(Project $project, array $files, Cloudinary $cloudinary): void
    {
        foreach ($files as $file) {
            $uploaded = $cloudinary->upload($file, 'portfolio/projects');

            ProjectImage::createAtPosition([
                'project_id' => $project->id,
                'url' => $uploaded['url'],
                'public_id' => $uploaded['public_id'],
                'position' => $project->images()->count() + 1,
            ]);
        }
    }
}
