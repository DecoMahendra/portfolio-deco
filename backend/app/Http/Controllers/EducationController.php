<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

// Pola yang sama dengan ExperienceController — penjelasan lengkap ada di sana.
class EducationController extends Controller
{
    public function index(): View
    {
        return view('admin.education.index', [
            'education' => Education::orderBy('sort_order')->get(),
        ]);
    }

    public function create(): View
    {
        // Posisi bawaan untuk data baru: paling akhir.
        return view('admin.education.create', ['nextPosition' => Education::count() + 1]);
    }

    public function store(Request $request): RedirectResponse
    {
        Education::createAtPosition($this->validated($request));

        return redirect()->route('admin.education.index')->with('status', 'Pendidikan ditambahkan.');
    }

    public function edit(Education $education): View
    {
        return view('admin.education.edit', ['education' => $education]);
    }

    public function update(Request $request, Education $education): RedirectResponse
    {
        $education->updateAtPosition($this->validated($request));

        return redirect()->route('admin.education.index')->with('status', 'Pendidikan disimpan.');
    }

    public function destroy(Education $education): RedirectResponse
    {
        $education->deleteAndCloseGap();

        return redirect()->route('admin.education.index')->with('status', 'Pendidikan dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'school' => ['required', 'string', 'max:255'],
            'program' => ['required', 'string', 'max:255'],
            'period' => ['required', 'string', 'max:255'],
            // position (mulai dari 1) diterjemahkan ke sort_order oleh trait HasSortOrder.
            'position' => ['required', 'integer', 'min:1'],
        ]);
    }
}
