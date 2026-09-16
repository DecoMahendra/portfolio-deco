<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\SkillGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/*
  Skill selalu milik satu kelompok, dan kelompoknya tidak bisa diganti:
  saat tambah, kelompok datang dari ?group= di alamat (link "+ Tambah skill");
  saat ubah, kelompok tetap yang sekarang. Tidak ada index: daftarnya sudah
  tampil di halaman kelompok, dan setelah simpan/hapus kembali ke sana.
*/
class SkillController extends Controller
{
    public function create(Request $request): View
    {
        // findOrFail: kalau ?group= kosong atau id-nya tidak ada, langsung 404.
        $group = SkillGroup::findOrFail($request->query('group'));

        return view('admin.skills.create', [
            'group' => $group,
            'nextPosition' => $group->skills()->count() + 1,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'skill_group_id' => ['required', 'integer', 'exists:skill_groups,id'],
            ...$this->rules($request->integer('skill_group_id')),
        ]);

        Skill::createAtPosition($data);

        return redirect()->route('admin.skill-groups.index')->with('status', 'Skill ditambahkan.');
    }

    public function edit(Skill $skill): View
    {
        return view('admin.skills.edit', ['skill' => $skill, 'group' => $skill->group]);
    }

    public function update(Request $request, Skill $skill): RedirectResponse
    {
        $skill->updateAtPosition($request->validate($this->rules($skill->skill_group_id, $skill)));

        return redirect()->route('admin.skill-groups.index')->with('status', 'Skill disimpan.');
    }

    public function destroy(Skill $skill): RedirectResponse
    {
        $skill->deleteAndCloseGap();

        return redirect()->route('admin.skill-groups.index')->with('status', 'Skill dihapus.');
    }

    private function rules(int $groupId, ?Skill $current = null): array
    {
        return [
            /*
              Nama skill unik HANYA di dalam kelompoknya (where skill_group_id),
              jadi "Git" boleh ada di dua kelompok berbeda. ignore: saat ubah,
              dirinya sendiri tidak dihitung.
            */
            'name' => [
                'required', 'string', 'max:255',
                Rule::unique('skills', 'name')->where('skill_group_id', $groupId)->ignore($current),
            ],
            'position' => ['required', 'integer', 'min:1'],
        ];
    }
}
