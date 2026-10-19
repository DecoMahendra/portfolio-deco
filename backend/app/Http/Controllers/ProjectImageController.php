<?php

namespace App\Http\Controllers;

use App\Models\ProjectImage;
use App\Services\Cloudinary;
use Illuminate\Http\RedirectResponse;

/*
  Hanya menghapus satu gambar project. Menambah dan mengubah gambar ada di
  ProjectController — ikut tersimpan lewat tombol Simpan project. Menghapus
  dibuat terpisah dan langsung, supaya tidak perlu Simpan dulu.

  Cloudinary $cloudinary diisi otomatis oleh Laravel (dependency injection).
*/
class ProjectImageController extends Controller
{
    public function destroy(ProjectImage $projectImage, Cloudinary $cloudinary): RedirectResponse
    {
        $project = $projectImage->project;

        // Database dulu, baru gambarnya. Kalau dibalik dan menghapus barisnya gagal,
        // database masih menunjuk ke gambar yang sudah hilang dari Cloudinary.
        $projectImage->deleteAndCloseGap();
        $cloudinary->delete($projectImage->public_id);

        return redirect()->route('admin.projects.edit', $project)->with('status', 'Gambar dihapus.');
    }
}
