<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

// Pola yang sama dengan ExperienceController, ditambah pengolahan kolom tech.
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
        return view('admin.projects.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Project::create($this->validated($request));

        return redirect()->route('admin.projects.index')->with('status', 'Project ditambahkan.');
    }

    public function edit(Project $project): View
    {
        return view('admin.projects.edit', ['project' => $project]);
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $project->update($this->validated($request));

        return redirect()->route('admin.projects.index')->with('status', 'Project disimpan.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()->route('admin.projects.index')->with('status', 'Project dihapus.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'tech' => ['required', 'string'],
            // nullable: boleh kosong. Kalau diisi, harus URL yang valid.
            'repo_url' => ['nullable', 'url', 'max:255'],
            'demo_url' => ['nullable', 'url', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:65535'],
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
}
