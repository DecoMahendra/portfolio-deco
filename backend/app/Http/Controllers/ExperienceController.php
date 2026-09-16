<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/*
  Resource controller = controller dengan nama method standar Laravel.
  Route::resource() memetakannya otomatis:

    GET    /admin/experiences            index    daftar
    GET    /admin/experiences/create     create   form tambah
    POST   /admin/experiences            store    simpan yang baru
    GET    /admin/experiences/{id}/edit  edit     form ubah
    PUT    /admin/experiences/{id}       update   simpan perubahan
    DELETE /admin/experiences/{id}       destroy  hapus

  Parameter Experience $experience di edit/update/destroy diisi otomatis
  oleh Laravel dari {id} di alamat (route model binding). Kalau id-nya
  tidak ada, Laravel langsung menjawab 404 tanpa kita cek manual.
*/
class ExperienceController extends Controller
{
    public function index(): View
    {
        return view('admin.experiences.index', [
            'experiences' => Experience::orderBy('sort_order')->get(),
        ]);
    }

    public function create(): View
    {
        // Posisi bawaan untuk data baru: paling akhir.
        return view('admin.experiences.create', ['nextPosition' => Experience::count() + 1]);
    }

    public function store(Request $request): RedirectResponse
    {
        Experience::createAtPosition($this->validated($request));

        return redirect()->route('admin.experiences.index')->with('status', 'Pengalaman ditambahkan.');
    }

    public function edit(Experience $experience): View
    {
        return view('admin.experiences.edit', ['experience' => $experience]);
    }

    public function update(Request $request, Experience $experience): RedirectResponse
    {
        $experience->updateAtPosition($this->validated($request));

        return redirect()->route('admin.experiences.index')->with('status', 'Pengalaman disimpan.');
    }

    public function destroy(Experience $experience): RedirectResponse
    {
        $experience->deleteAndCloseGap();

        return redirect()->route('admin.experiences.index')->with('status', 'Pengalaman dihapus.');
    }

    // Aturan validasi sama untuk tambah dan ubah, jadi ditaruh di satu tempat.
    private function validated(Request $request): array
    {
        return $request->validate([
            'role' => ['required', 'string', 'max:255'],
            'company' => ['required', 'string', 'max:255'],
            'period' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            // position (mulai dari 1) diterjemahkan ke sort_order oleh trait HasSortOrder.
            'position' => ['required', 'integer', 'min:1'],
        ]);
    }
}
