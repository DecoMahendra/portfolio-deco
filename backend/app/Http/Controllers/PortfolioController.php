<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\SkillGroup;
use Illuminate\Http\JsonResponse;

/*
  Controller = yang menyiapkan jawaban untuk sebuah route.
  Route hanya bilang "alamat /api/portfolio dilayani PortfolioController",
  isi jawabannya disusun di sini.

  Controller ini hanya punya satu tugas, jadi cukup satu method __invoke:
  Laravel memanggilnya otomatis tanpa perlu menyebut nama method di route.
*/
class PortfolioController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'profile' => Profile::first(),

            // with('skills') mengambil semua skill sekaligus dalam satu query,
            // bukan satu query per kelompok. Urutan skill diatur di relasi model.
            'skills' => SkillGroup::with('skills')->orderBy('sort_order')->get(),

            'experiences' => Experience::orderBy('sort_order')->get(),
            'education' => Education::orderBy('sort_order')->get(),
            'projects' => Project::with('images')->orderBy('sort_order')->get(),
            'certificates' => Certificate::orderBy('sort_order')->get(),
        ]);
    }
}
