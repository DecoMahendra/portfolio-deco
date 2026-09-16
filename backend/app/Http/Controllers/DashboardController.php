<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'counts' => [
                'Keahlian' => Skill::count(),
                'Pengalaman' => Experience::count(),
                'Pendidikan' => Education::count(),
                'Project' => Project::count(),
                'Sertifikat' => Certificate::count(),
            ],
        ]);
    }
}
