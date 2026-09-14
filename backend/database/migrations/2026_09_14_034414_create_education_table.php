<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
  Tabel riwayat pendidikan.

  Nama tabelnya "education" (bukan "educations") karena kata itu memang
  tidak punya bentuk jamak dalam bahasa Inggris — Laravel mengenalinya.

  Padanannya di frontend: src/data/education.js
*/
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('education', function (Blueprint $table) {
            $table->id();
            $table->string('school');
            $table->string('program');
            $table->string('period');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('education');
    }
};
