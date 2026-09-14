<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/*
  Seeder utama — yang dipanggil oleh "php artisan db:seed".
  Tugasnya cuma memanggil seeder lain, supaya tiap kelompok data
  punya file sendiri yang mudah dicari.

  Seeder User bawaan Laravel dihapus: akun admin dibuat di Phase 12
  saat dashboard-nya ada, bukan sekarang.
*/
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PortfolioSeeder::class,
        ]);
    }
}
