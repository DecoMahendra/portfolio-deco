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
        $cloudinary->delete($projectImage->public_id);
        $projectImage->deleteAndCloseGap();

        return redirect()->route('admin.projects.edit', $projectImage->project)->with('status', 'Gambar dihapus.');
    }
}
