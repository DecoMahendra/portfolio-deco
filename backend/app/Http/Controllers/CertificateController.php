<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

// Pola yang sama dengan ExperienceController — penjelasan lengkap ada di sana.
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

    public function store(Request $request): RedirectResponse
    {
        Certificate::createAtPosition($this->validated($request));

        return redirect()->route('admin.certificates.index')->with('status', 'Sertifikat ditambahkan.');
    }

    public function edit(Certificate $certificate): View
    {
        return view('admin.certificates.edit', ['certificate' => $certificate]);
    }

    public function update(Request $request, Certificate $certificate): RedirectResponse
    {
        $certificate->updateAtPosition($this->validated($request));

        return redirect()->route('admin.certificates.index')->with('status', 'Sertifikat disimpan.');
    }

    public function destroy(Certificate $certificate): RedirectResponse
    {
        $certificate->deleteAndCloseGap();

        return redirect()->route('admin.certificates.index')->with('status', 'Sertifikat dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'organizer' => ['required', 'string', 'max:255'],
            'year' => ['required', 'string', 'max:255'],
            // position (mulai dari 1) diterjemahkan ke sort_order oleh trait HasSortOrder.
            'position' => ['required', 'integer', 'min:1'],
        ]);
    }
}
