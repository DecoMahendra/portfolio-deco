<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SkillGroup extends Model
{
    protected $fillable = ['name', 'sort_order'];

    /*
      Relasi: satu kelompok PUNYA BANYAK skill.
      Laravel mencari kolom skill_group_id di tabel skills secara otomatis.

      Cara pakai: $group->skills  ->  daftar skill di kelompok ini.
    */
    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class)->orderBy('sort_order');
    }
}
