<?php

namespace App\Console\Commands;

use App\Support\PortfolioData;
use Illuminate\Console\Command;

/*
  Perintah terminal: php artisan portfolio:export

  Menulis seluruh data portfolio jadi satu berkas JSON di dalam frontend.
  Berkas itu ikut ter-commit dan ikut dibangun bersama React, jadi website
  bisa menampilkan isinya seketika tanpa menunggu jaringan — dan tetap
  tampil normal walaupun API sedang mati.

  Alur memperbarui isi website:
  1. ubah data lewat dashboard admin
  2. php artisan portfolio:export
  3. git add, commit, push  ->  Vercel membangun ulang website
*/
class PortfolioExport extends Command
{
    protected $signature = 'portfolio:export';

    protected $description = 'Menulis data portfolio jadi berkas JSON di frontend';

    public function handle(): int
    {
        // base_path() = folder backend/, jadi ".." naik ke folder project.
        $path = base_path('../frontend/src/data/portfolio.json');

        /*
          PRETTY_PRINT: mudah dibaca manusia dan perubahannya jelas terlihat di Git.
          UNESCAPED_SLASHES & UNESCAPED_UNICODE: alamat dan huruf beraksen ditulis
          apa adanya, tidak diubah jadi kode seperti "\/" atau "—".
        */
        $json = json_encode(
            PortfolioData::all(),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );

        file_put_contents($path, $json.PHP_EOL);

        $this->info('Data portfolio ditulis ke frontend/src/data/portfolio.json ('.number_format(strlen($json) / 1024, 1).' KB).');
        $this->line('Langkah berikutnya: commit dan push supaya website ikut diperbarui.');

        return self::SUCCESS;
    }
}
