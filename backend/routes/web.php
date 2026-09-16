<?php

use App\Http\Controllers\CertificateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\SkillGroupController;
use Illuminate\Support\Facades\Route;

/*
  Route web = alamat yang mengembalikan halaman HTML (dashboard admin).
  Alamat yang mengembalikan JSON untuk frontend React ada di api.php.

  Middleware:
  - guest    : hanya untuk yang BELUM login; yang sudah login dilempar ke dashboard
  - auth     : hanya untuk yang SUDAH login; yang belum dilempar ke halaman login
  - throttle : maksimal 5 percobaan login per menit dari satu alamat IP
*/

Route::redirect('/', '/admin');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:5,1');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    /*
      prefix('admin') : semua alamat di dalamnya diawali /admin/...
      name('admin.')  : semua nama route diawali admin. — dipakai di route('admin.xxx')
    */
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', DashboardController::class)->name('dashboard');

        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

        // except('show'): halaman detail tidak dibutuhkan, cukup daftar + form.
        Route::resource('experiences', ExperienceController::class)->except('show');
        Route::resource('education', EducationController::class)->except('show');
        Route::resource('projects', ProjectController::class)->except('show');
        Route::resource('certificates', CertificateController::class)->except('show');

        // Skill: daftarnya ada di halaman kelompok, jadi skills tidak punya index.
        Route::resource('skill-groups', SkillGroupController::class)->except('show');
        Route::resource('skills', SkillController::class)->except(['index', 'show']);
    });
});
