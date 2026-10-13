<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
  Foto profil (bagian "Tentang saya") — sekarang bisa diunggah lewat dashboard.
  Sama seperti gambar sertifikat: file ada di Cloudinary, di sini hanya
  url (untuk ditampilkan) dan public_id (untuk dihapus saat diganti).

  nullable: selama belum ada foto yang diunggah, website menampilkan ikon
  pengganti. Foto profil hanya bisa ditambahkan lewat dashboard.
*/
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('photo_url')->nullable()->after('photo_alt');
            $table->string('photo_public_id')->nullable()->after('photo_url');
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn(['photo_url', 'photo_public_id']);
        });
    }
};
