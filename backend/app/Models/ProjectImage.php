<?php

namespace App\Models;

use App\Models\Concerns\HasSortOrder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectImage extends Model
{
    use HasSortOrder;

    protected $fillable = ['project_id', 'url', 'public_id', 'alt', 'sort_order'];

    // Satu gambar MILIK satu project. Cara pakai: $image->project
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    // Urutan slide hanya berlaku di dalam project-nya, bukan seluruh tabel.
    protected function sortSiblings(): Builder
    {
        return static::where('project_id', $this->project_id);
    }
}
