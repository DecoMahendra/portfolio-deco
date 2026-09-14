<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
  Tabel project / karya.

  Padanannya di frontend: src/data/projects.js
*/
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');

            // Daftar teknologi disimpan sebagai JSON: ["React", "Vite", ...]
            // Laravel otomatis mengubahnya jadi array PHP saat dibaca.
            // Dipilih JSON (bukan tabel terpisah) karena daftar ini hanya
            // label tampilan — tidak pernah dicari atau difilter.
            $table->json('tech');

            // nullable = boleh kosong. Tidak semua project punya repo publik
            // atau sudah online.
            $table->string('repo_url')->nullable();
            $table->string('demo_url')->nullable();

            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
