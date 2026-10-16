<?php

namespace App\Support;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Process;
use RuntimeException;

/*
  Menerbitkan isi portfolio ke website, langsung dari dashboard.

  Website (Vercel) dibangun dari portfolio.json yang ada di GitHub. Jadi
  "menerbitkan" = ekspor data ke berkas itu, commit, lalu push — perintah
  git yang sama dengan yang dulu diketik manual di terminal.

  Aturan pengaman:
  - yang di-commit HANYA portfolio.json. Kode lain yang sedang dikerjakan
    tidak pernah ikut terbawa, walaupun sudah di-stage.
  - tidak push kalau ada commit LAIN yang belum di-push. Push mengirim semua
    commit sekaligus, jadi tanpa aturan ini tombol Terbitkan bisa diam-diam
    menerbitkan kode yang belum siap.
  - tidak ada perubahan = tidak ada commit.

  Hanya aktif di komputer yang punya repo Git dan folder frontend. Kalau nanti
  backend di-deploy ke server, keduanya tidak ada dan fitur ini mati sendiri.
*/
class PortfolioPublisher
{
    // Jalur relatif terhadap folder project, sama seperti yang ditulis git.
    private const DATA_FILE = 'frontend/src/data/portfolio.json';

    private const COMMIT_MESSAGE = 'chore: publish portfolio content';

    public static function isAvailable(): bool
    {
        return is_dir(self::root().'/.git') && is_dir(self::root().'/frontend');
    }

    public static function export(): void
    {
        Artisan::call('portfolio:export');
    }

    // Isi di komputer ini berbeda dari yang sudah ada di GitHub (= yang dipakai website)?
    public static function hasUnpublishedChanges(): bool
    {
        return self::dataFileChanged() || in_array(self::DATA_FILE, self::unpushedFiles(), true);
    }

    // Mengembalikan pesan untuk ditampilkan di dashboard.
    public static function publish(): string
    {
        if (self::git('rev-parse', '--abbrev-ref', 'HEAD') !== 'main') {
            throw new RuntimeException('Terbitkan hanya bisa dari branch main.');
        }

        // Diperiksa di awal supaya pesannya jelas, bukan error git yang panjang di tengah jalan.
        if (! self::hasGitIdentity()) {
            throw new RuntimeException(
                'Git tidak menemukan nama/email Anda. Atur lewat terminal: '
                .'git config --global user.name "Nama Anda" dan git config --global user.email "email@anda.com".'
            );
        }

        self::export();

        $otherFiles = array_values(array_diff(self::unpushedFiles(), [self::DATA_FILE]));
        if ($otherFiles) {
            throw new RuntimeException(
                'Ada commit lain yang belum di-push (mengubah '.implode(', ', $otherFiles).'). '
                .'Push dulu lewat terminal kalau memang sudah siap, lalu tekan Terbitkan lagi.'
            );
        }

        if (self::dataFileChanged()) {
            // "commit -- <berkas>": hanya berkas ini yang masuk commit,
            // berkas lain yang sedang di-stage dibiarkan apa adanya.
            self::git('commit', '-m', self::COMMIT_MESSAGE, '--', self::DATA_FILE);
        } elseif (! self::unpushedFiles()) {
            return 'Tidak ada perubahan untuk diterbitkan — website sudah sama dengan isi dashboard.';
        }

        // Sampai di sini, commit yang belum di-push hanya berisi portfolio.json:
        // commit barusan, atau sisa dari percobaan sebelumnya yang push-nya gagal.
        self::git('push');

        return 'Diterbitkan. Website akan berubah dalam sekitar 1 menit.';
    }

    private static function hasGitIdentity(): bool
    {
        try {
            return self::git('config', 'user.email') !== '';
        } catch (RuntimeException) {
            // "git config" gagal (kode keluar 1) kalau pengaturannya tidak ditemukan sama sekali.
            return false;
        }
    }

    private static function dataFileChanged(): bool
    {
        return self::git('status', '--porcelain', '--', self::DATA_FILE) !== '';
    }

    // Berkas apa saja yang diubah oleh commit yang belum di-push.
    private static function unpushedFiles(): array
    {
        $output = self::git('diff', '--name-only', '@{upstream}..HEAD');

        return $output === '' ? [] : preg_split('/\R/', $output);
    }

    private static function git(string ...$args): string
    {
        /*
          env(getenv()): teruskan SEMUA variabel lingkungan ke git.

          Tanpa ini, saat dijalankan dari halaman web, Process hanya meneruskan
          variabel yang juga ada di $_SERVER — dan USERPROFILE/HOME tidak ada di
          sana. Akibatnya git tidak menemukan folder profil pengguna: commit gagal
          "Author identity unknown" (nama & email ada di ~/.gitconfig), dan push
          gagal karena Credential Manager tidak tahu letak data loginnya.
          Dari terminal masalah ini tidak muncul, karena di sana semua variabel ikut.

          GIT_TERMINAL_PROMPT & GCM_INTERACTIVE: jangan pernah MENUNGGU masukan
          (misalnya login GitHub kedaluwarsa). Dari halaman web tidak ada yang bisa
          mengetik jawabannya, jadi lebih baik langsung gagal dengan pesan yang jelas.
        */
        $env = [...getenv(), 'GIT_TERMINAL_PROMPT' => '0', 'GCM_INTERACTIVE' => 'never'];
        $result = Process::path(self::root())->env($env)->timeout(60)->run(['git', ...$args]);

        if ($result->failed()) {
            // Baris peringatan akhir baris (CRLF/LF) dibuang: tidak berbahaya,
            // tapi menenggelamkan pesan error yang sebenarnya.
            $error = collect(preg_split('/\R/', trim($result->errorOutput())))
                ->reject(fn ($line) => str_starts_with($line, 'warning: in the working copy'))
                ->implode(' ');

            throw new RuntimeException('Perintah "git '.$args[0].'" gagal: '.$error);
        }

        return trim($result->output());
    }

    // base_path() = folder backend/, jadi induknya adalah folder project.
    private static function root(): string
    {
        return dirname(base_path());
    }
}
