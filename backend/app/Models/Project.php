<?php

namespace App\Models;

use App\Models\Concerns\HasSortOrder;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasSortOrder;

    protected $fillable = ['name', 'description', 'tech', 'repo_url', 'demo_url', 'sort_order'];

    /*
      $casts = cara Laravel mengubah tipe data saat baca/tulis.

      'tech' => 'array' artinya:
      - saat DISIMPAN: array PHP ["React","Vite"] diubah jadi teks JSON
      - saat DIBACA : teks JSON dari database diubah kembali jadi array PHP

      Jadi di kode kita cukup pakai $project->tech sebagai array biasa,
      tanpa perlu json_encode / json_decode manual.
    */
    protected $casts = [
        'tech' => 'array',
    ];
}
