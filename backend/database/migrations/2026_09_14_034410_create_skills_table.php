<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
  Tabel keahlian: "React", "Laravel", "MySQL", dst.

  Tiap baris menunjuk ke satu kelompok lewat skill_group_id.
  Ini relasi one-to-many: satu kelompok punya banyak skill,
  satu skill hanya milik satu kelompok.

  Padanannya di frontend: src/data/skills.js -> items
*/
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->id();

            // Kunci asing ke skill_groups.id.
            // cascadeOnDelete = kalau kelompoknya dihapus, semua skill di
            // dalamnya ikut terhapus. Skill tanpa kelompok tidak masuk akal.
            $table->foreignId('skill_group_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('name');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};
