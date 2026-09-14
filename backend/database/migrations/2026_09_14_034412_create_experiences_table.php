<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
  Tabel riwayat pengalaman: magang, organisasi, PKL.

  Padanannya di frontend: src/data/experience.js
*/
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->string('role');
            $table->string('company');

            // Disimpan sebagai teks apa adanya ("Juli 2026 — Sekarang"),
            // sama seperti yang ditampilkan di frontend. Kalau nanti butuh
            // pengurutan otomatis berdasarkan tanggal, kolom ini bisa dipecah
            // jadi start_date dan end_date.
            $table->string('period');

            $table->text('description');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};
