<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
  Tabel profil — data diri pemilik portfolio.

  Isinya hanya SATU baris, karena portfolio ini milik satu orang.
  Dibuat sebagai tabel (bukan hardcode di kode) supaya bisa diubah lewat
  dashboard tanpa menyentuh kode.

  Padanannya di frontend: src/data/profile.js
*/
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role');
            $table->string('location');
            $table->string('availability');
            $table->text('tagline');

            // Bio bisa beberapa paragraf, jadi text (bukan string yang
            // dibatasi 255 huruf). Paragraf dipisah baris kosong.
            $table->text('bio');

            $table->string('photo_alt');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
