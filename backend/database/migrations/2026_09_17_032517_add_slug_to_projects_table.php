<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

/*
  Menambah kolom slug ke tabel projects.

  Slug = versi nama yang aman dipakai di alamat web:
  "Website Portfolio Pribadi" -> "website-portfolio-pribadi".
  Dipakai frontend untuk halaman /projects/website-portfolio-pribadi.

  Tabelnya sudah berisi data, jadi tidak bisa langsung menambah kolom
  wajib + unik (baris lama akan kosong semua dan saling bentrok). Urutannya:
  1. tambah kolom boleh-kosong
  2. isi slug untuk baris yang sudah ada
  3. baru kunci: wajib diisi dan unik
*/
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('name');
        });

        foreach (DB::table('projects')->get() as $project) {
            DB::table('projects')
                ->where('id', $project->id)
                ->update(['slug' => Str::slug($project->name)]);
        }

        Schema::table('projects', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->change();
            $table->unique('slug');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });
    }
};
