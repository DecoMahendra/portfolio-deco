<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
  Gambar sertifikat — satu gambar, opsional.
  Sama seperti project_images: file ada di Cloudinary, di sini hanya
  url (untuk ditampilkan) dan public_id (untuk dihapus). Keduanya nullable
  karena tidak semua sertifikat punya gambar.
*/
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->string('image_url')->nullable()->after('year');
            $table->string('image_public_id')->nullable()->after('image_url');
        });
    }

    public function down(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->dropColumn(['image_url', 'image_public_id']);
        });
    }
};
