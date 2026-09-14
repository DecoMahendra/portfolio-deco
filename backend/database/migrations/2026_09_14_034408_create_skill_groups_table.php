<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
  Tabel kelompok keahlian: "Pengembangan Web", "Bahasa Pemrograman", dst.

  Dipisah dari tabel skills supaya nama kelompok disimpan SATU kali.
  Kalau namanya diubah, semua skill di dalamnya otomatis ikut —
  tidak perlu mengubah satu per satu.

  Padanannya di frontend: src/data/skills.js -> category
*/
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skill_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            // Urutan tampil. Diatur manual dari dashboard, bukan mengikuti id —
            // supaya kelompok baru bisa disisipkan di mana saja.
            $table->unsignedSmallInteger('sort_order')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skill_groups');
    }
};
