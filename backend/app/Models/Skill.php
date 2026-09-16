<?php

namespace App\Models;

use App\Models\Concerns\HasSortOrder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Skill extends Model
{
    use HasSortOrder;

    protected $fillable = ['skill_group_id', 'name', 'sort_order'];

    /*
      Relasi kebalikan dari SkillGroup::skills().
      Satu skill MILIK satu kelompok.

      Cara pakai: $skill->group  ->  kelompok tempat skill ini berada.
    */
    public function group(): BelongsTo
    {
        return $this->belongsTo(SkillGroup::class, 'skill_group_id');
    }

    // Urutan skill hanya berlaku di dalam kelompoknya, bukan seluruh tabel.
    protected function sortSiblings(): Builder
    {
        return static::where('skill_group_id', $this->skill_group_id);
    }
}
