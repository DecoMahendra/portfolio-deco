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
        return view('admin.education.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Education::create($this->validated($request));

        return redirect()->route('admin.education.index')->with('status', 'Pendidikan ditambahkan.');
    }

    public function edit(Education $education): View
    {
        return view('admin.education.edit', ['education' => $education]);
    }

    public function update(Request $request, Education $education): RedirectResponse
    {
        $education->update($this->validated($request));

        return redirect()->route('admin.education.index')->with('status', 'Pendidikan disimpan.');
    }

    public function destroy(Education $education): RedirectResponse
    {
        $education->delete();

        return redirect()->route('admin.education.index')->with('status', 'Pendidikan dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'school' => ['required', 'string', 'max:255'],
            'program' => ['required', 'string', 'max:255'],
            'period' => ['required', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:65535'],
        ]);
    }
}
