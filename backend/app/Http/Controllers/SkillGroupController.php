<?php

namespace App\Http\Controllers;

use App\Models\SkillGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/*
  Kelompok skill. Halaman index-nya sekaligus menampilkan skill di dalam
  tiap kelompok, jadi SkillController tidak perlu punya index sendiri.
*/
class SkillGroupController extends Controller
{
    public function index(): View
    {
        return view('admin.skill-groups.index', [
            // with('skills'): ambil semua skill sekaligus, bukan satu query per kelompok.
            'groups' => SkillGroup::with('skills')->orderBy('sort_order')->get(),
        ]);
    }

    public function create(): View
    {
        // Posisi bawaan untuk data baru: paling akhir.
        return view('admin.skill-groups.create', ['nextPosition' => SkillGroup::count() + 1]);
    }

    public function store(Request $request): RedirectResponse
    {
        SkillGroup::createAtPosition($this->validated($request));

        return redirect()->route('admin.skill-groups.index')->with('status', 'Kelompok ditambahkan.');
    }

    public function edit(SkillGroup $skillGroup): View
    {
        return view('admin.skill-groups.edit', ['group' => $skillGroup]);
    }

    public function update(Request $request, SkillGroup $skillGroup): RedirectResponse
    {
        $skillGroup->updateAtPosition($this->validated($request, $skillGroup));

        return redirect()->route('admin.skill-groups.index')->with('status', 'Kelompok disimpan.');
    }

    public function destroy(SkillGroup $skillGroup): RedirectResponse
    {
        // Skill di dalamnya ikut terhapus oleh database (cascadeOnDelete di migration).
        $skillGroup->deleteAndCloseGap();

        return redirect()->route('admin.skill-groups.index')->with('status', 'Kelompok beserta skill di dalamnya dihapus.');
    }

    private function validated(Request $request, ?SkillGroup $current = null): array
    {
        return $request->validate([
            // unique: nama kelompok tidak boleh kembar. ignore: saat ubah, dirinya sendiri tidak dihitung.
            'name' => ['required', 'string', 'max:255', Rule::unique('skill_groups', 'name')->ignore($current)],
            'position' => ['required', 'integer', 'min:1'],
        ]);
    }
}
