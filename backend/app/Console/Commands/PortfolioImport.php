<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/*
  Perintah terminal: php artisan portfolio:import

  Kebalikan dari portfolio:export — mengisi database dari frontend/src/data/portfolio.json.
  Gunanya untuk MEMULIHKAN: kalau database Aiven hilang (layanan gratis bisa
  dimatikan atau dihapus kalau lama tidak dipakai), seluruh isi portfolio bisa
  dikembalikan tanpa mengetik ulang. Berkas itu ikut ter-commit setiap kali
  tombol Terbitkan ditekan, jadi selalu ada salinan terbarunya di Git.

  Yang TIDAK dipulihkan: akun admin (buat ulang dengan php artisan admin:create)
  dan gambarnya sendiri — gambar tetap tersimpan di Cloudinary, di sini hanya
  alamatnya.

  Pengaman:
  - hanya mau mengisi database yang KOSONG. Perintah pemulihan tidak boleh bisa
    menimpa atau menggandakan data yang ada, walaupun salah dijalankan.
  - id asli dipertahankan, supaya hubungan skill -> kelompok dan
    gambar -> project tetap tersambung.
  - semua masuk dalam satu transaksi: gagal di tengah = tidak ada yang tersimpan.
*/
class PortfolioImport extends Command
{
    protected $signature = 'portfolio:import';

    protected $description = 'Memulihkan isi database dari frontend/src/data/portfolio.json';

    // Urutan penting: induk dulu (skill_groups, projects), baru anaknya.
    private const TABLES = ['profiles', 'skill_groups', 'skills', 'experiences', 'education', 'projects', 'project_images', 'certificates'];

    public function handle(): int
    {
        $path = base_path('../frontend/src/data/portfolio.json');

        if (! is_file($path)) {
            $this->error('Berkas tidak ditemukan: frontend/src/data/portfolio.json');

            return self::FAILURE;
        }

        $data = json_decode(file_get_contents($path), true);

        if (! is_array($data)) {
            $this->error('Isi portfolio.json bukan JSON yang valid.');

            return self::FAILURE;
        }

        $filled = array_filter(self::TABLES, fn ($table) => DB::table($table)->exists());

        if ($filled) {
            $this->error('Database sudah berisi data (tabel: '.implode(', ', $filled).').');
            $this->line('Impor hanya untuk memulihkan ke database KOSONG, supaya data yang ada tidak tertimpa atau ganda.');

            return self::FAILURE;
        }

        // Data bertingkat di JSON (skill di dalam kelompok, gambar di dalam project)
        // dipisah menjadi baris per tabel.
        $rows = [
            'profiles' => array_filter([$data['profile'] ?? null]),
            'skill_groups' => $data['skills'] ?? [],
            'skills' => array_merge(...array_map(fn ($group) => $group['skills'] ?? [], $data['skills'] ?? [])),
            'experiences' => $data['experiences'] ?? [],
            'education' => $data['education'] ?? [],
            'projects' => $data['projects'] ?? [],
            'project_images' => array_merge(...array_map(fn ($project) => $project['images'] ?? [], $data['projects'] ?? [])),
            'certificates' => $data['certificates'] ?? [],
        ];

        DB::transaction(function () use ($rows) {
            foreach (self::TABLES as $table) {
                $columns = Schema::getColumnListing($table);

                foreach ($rows[$table] as $row) {
                    DB::table($table)->insert($this->toDatabaseRow($row, $columns));
                }
            }
        });

        foreach (self::TABLES as $table) {
            $this->line(str_pad($table, 16).count($rows[$table]).' baris');
        }

        $this->info('Database dipulihkan dari portfolio.json.');
        $this->line('Langkah berikutnya: buat akun admin dengan php artisan admin:create.');

        return self::SUCCESS;
    }

    /*
      Satu baris JSON -> satu baris tabel:
      - hanya kolom yang memang ada di tabel (data bertingkat seperti "images" dibuang)
      - array (kolom tech) disimpan kembali sebagai teks JSON
      - tanggal "2026-09-19T14:29:52.000000Z" diubah ke bentuk MySQL "2026-09-19 14:29:52"
    */
    private function toDatabaseRow(array $row, array $columns): array
    {
        $row = array_intersect_key($row, array_flip($columns));

        foreach ($row as $column => $value) {
            if (is_array($value)) {
                $row[$column] = json_encode($value, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            } elseif (in_array($column, ['created_at', 'updated_at'], true) && $value !== null) {
                $row[$column] = Carbon::parse($value)->setTimezone(config('app.timezone'))->format('Y-m-d H:i:s');
            }
        }

        return $row;
    }
}
