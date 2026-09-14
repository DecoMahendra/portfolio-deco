<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
  Tabel pelatihan & sertifikasi.

  Padanannya di frontend: src/data/certificates.js
*/
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('organizer');

            // Teks, bukan angka — karena bisa "2023, 2024, 2025" untuk
            // kegiatan yang berulang tiap tahun.
            $table->string('year');

            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
