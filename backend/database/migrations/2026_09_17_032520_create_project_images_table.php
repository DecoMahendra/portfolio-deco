<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
  Gambar project — satu project bisa punya banyak gambar (slide).

  File gambarnya sendiri TIDAK disimpan di sini, melainkan di Cloudinary
  (layanan penyimpanan gambar). Tabel ini hanya mencatat:
  - url       : alamat gambar di Cloudinary, dipakai frontend untuk menampilkan
  - public_id : "nama file" di Cloudinary, dipakai saat gambar dihapus
*/
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_images', function (Blueprint $table) {
            $table->id();

            // Kalau project dihapus, semua gambarnya ikut terhapus dari tabel ini.
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();

            $table->string('url');
            $table->string('public_id');

            // Teks alternatif untuk pembaca layar. Boleh kosong: nanti
            // frontend memakai nama project sebagai gantinya.
            $table->string('alt')->nullable();

            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_images');
    }
};
