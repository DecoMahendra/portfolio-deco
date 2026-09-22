<?php

namespace App\Support;

use App\Models\Certificate;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\SkillGroup;

/*
  Penyusun data portfolio — satu tempat, dua pemakai:
  - PortfolioController : mengirimkannya sebagai JSON lewat /api/portfolio
  - PortfolioExport     : menuliskannya jadi berkas cadangan di frontend

  Ditaruh di sini supaya bentuk datanya tidak pernah berbeda antara keduanya.
  Kalau berbeda, frontend akan menampilkan hal yang berbeda saat API hidup
  dan saat API mati — bug yang sangat sulit dilacak.
*/
class PortfolioData
{
    public static function all(): array
    {
        return [
            'profile' => Profile::first(),

            // with(): ambil data anaknya sekaligus dalam satu query, bukan satu per induk.
            'skills' => SkillGroup::with('skills')->orderBy('sort_order')->get(),

            'experiences' => Experience::orderBy('sort_order')->get(),
            'education' => Education::orderBy('sort_order')->get(),
            'projects' => Project::with('images')->orderBy('sort_order')->get(),
            'certificates' => Certificate::orderBy('sort_order')->get(),
        ];
    }
}
