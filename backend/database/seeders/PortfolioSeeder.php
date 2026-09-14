<?php

namespace Database\Seeders;

use App\Models\Certificate;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\SkillGroup;
use Illuminate\Database\Seeder;

/*
  Seeder = pengisi data awal.

  Isinya disalin dari frontend/src/data/*.js supaya database berisi data
  yang sama persis dengan yang sekarang tampil di website. Nanti di Phase 13
  frontend akan membaca dari sini, bukan dari file .js lagi.

  Cara menjalankan: php artisan db:seed
  Aman dijalankan berulang — data lama dihapus dulu sebelum diisi ulang.
*/
class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedProfile();
        $this->seedSkills();
        $this->seedExperiences();
        $this->seedEducation();
        $this->seedProjects();
        $this->seedCertificates();
    }

    private function seedProfile(): void
    {
        Profile::query()->delete();

        Profile::create([
            'name' => 'Deco Mahendra',
            'role' => 'Full Stack Developer',
            'location' => 'Indramayu, Jawa Barat',
            'availability' => 'Terbuka untuk project freelance',
            'tagline' => 'Full Stack Developer yang membangun website modern, responsif, dan berorientasi pada pengalaman pengguna.',

            // Dua paragraf, dipisah baris kosong — sesuai catatan di migration.
            'bio' => implode("\n\n", [
                'Mahasiswa D4 Sistem Informasi Kota Cerdas di Politeknik Negeri Indramayu, dengan ketertarikan dalam membangun aplikasi web modern dari sisi frontend hingga backend.',
                'Saya senang mempelajari teknologi baru, menyelesaikan masalah melalui kode, dan mengembangkan project yang memiliki tampilan menarik serta fungsional.',
            ]),

            'photo_alt' => 'Foto Deco Mahendra',
        ]);
    }

    private function seedSkills(): void
    {
        // Menghapus kelompok otomatis menghapus skill di dalamnya (cascadeOnDelete).
        SkillGroup::query()->delete();

        $groups = [
            'Pengembangan Web' => ['HTML', 'CSS', 'JavaScript', 'React', 'Laravel', 'Tailwind CSS'],
            'Bahasa Pemrograman' => ['PHP', 'Java', 'Python'],
            'Basis Data & Pengolahan Data' => ['MySQL', 'Pandas', 'NumPy'],
            'Mobile & IoT' => ['Flutter', 'Internet of Things'],
            'Tools' => ['Git', 'GitHub', 'Vite'],
        ];

        $order = 0;
        foreach ($groups as $groupName => $skillNames) {
            $group = SkillGroup::create([
                'name' => $groupName,
                'sort_order' => $order++,
            ]);

            foreach ($skillNames as $i => $skillName) {
                // $group->skills()->create() otomatis mengisi skill_group_id.
                $group->skills()->create([
                    'name' => $skillName,
                    'sort_order' => $i,
                ]);
            }
        }
    }

    private function seedExperiences(): void
    {
        Experience::query()->delete();

        $items = [
            [
                'role' => 'Full Stack Developer Intern',
                'company' => 'PT. Pilar Timur Teknologi (Digital Oasis)',
                'period' => 'Juli 2026 — Sekarang',
                'description' => 'Berkontribusi dalam pengembangan project TelU-X pada sisi Admin, Client, dan integrasi Moodle. Menganalisis temuan bug berdasarkan dokumentasi UAT, melakukan perbaikan, serta memastikan fitur kembali berjalan sesuai kebutuhan sistem.',
            ],
            [
                'role' => 'Koordinator Dewan Permusyawaratan Mahasiswa',
                'company' => 'Himpunan Mahasiswa Sistem Informasi Kota Cerdas (HIMA-SIKC)',
                'period' => '2025 — 2026',
                'description' => 'Memimpin dan mengoordinasikan pengawasan terhadap jalannya kepengurusan HIMA-SIKC bersama anggota bidang, serta memberikan bimbingan dan masukan atas pengelolaan organisasi. Mewakili DPM dalam berkoordinasi dengan Ketua Himpunan di setiap kegiatan, turut terlibat langsung dalam pelaksanaan pengawasan di lapangan, dan mempertanggungjawabkan hasilnya pada Musyawarah Besar.',
            ],
            [
                'role' => 'Ketua Himpunan',
                'company' => 'Himpunan Mahasiswa Sistem Informasi Kota Cerdas (HIMA-SIKC)',
                'period' => '2024 — 2025',
                'description' => 'Memimpin dan bertanggung jawab atas jalannya kepengurusan HIMA-SIKC selama satu periode, mencakup koordinasi program kerja, rapat pengurus, dan evaluasi triwulan. Merumuskan SOP organisasi serta job description tiap divisi bersama pengurus harian, dan berkoordinasi dengan Pembina dan DPM di setiap pelaksanaan kegiatan.',
            ],
            [
                'role' => 'Praktik Kerja Lapangan',
                'company' => 'Percetakan Fdot Indramayu',
                'period' => 'Februari — April 2022',
                'description' => 'Mendesain surat, banner, dan spanduk menggunakan CorelDRAW dan Photoshop, serta berkontribusi dalam pembuatan piala akrilik dan piagam.',
            ],
        ];

        foreach ($items as $i => $item) {
            Experience::create($item + ['sort_order' => $i]);
        }
    }

    private function seedEducation(): void
    {
        Education::query()->delete();

        $items = [
            ['school' => 'Politeknik Negeri Indramayu', 'program' => 'D4 Sistem Informasi Kota Cerdas', 'period' => '2023 — Sekarang'],
            ['school' => 'SMK Negeri Indramayu', 'program' => 'Multimedia', 'period' => '2019 — 2022'],
        ];

        foreach ($items as $i => $item) {
            Education::create($item + ['sort_order' => $i]);
        }
    }

    private function seedProjects(): void
    {
        Project::query()->delete();

        Project::create([
            'name' => 'Website Portfolio Pribadi',
            'description' => 'Website portfolio satu halaman yang dibangun dari nol tanpa template. Memiliki design system sendiri, navigasi yang otomatis menandai bagian yang sedang dibaca, serta dukungan navigasi keyboard dan pembaca layar. Backend Laravel dan dashboard admin sedang dalam rencana pengembangan.',
            'tech' => ['React', 'Vite', 'Tailwind CSS', 'JavaScript'],
            'repo_url' => 'https://github.com/DecoMahendra/portfolio-deco',
            'demo_url' => null,
            'sort_order' => 0,
        ]);
    }

    private function seedCertificates(): void
    {
        Certificate::query()->delete();

        $items = [
            ['name' => 'Pelatihan Dasar Artificial Intelligence', 'organizer' => 'Dicoding Academy', 'year' => '2025'],
            ['name' => 'Pemateri Kegiatan Himpunan Mahasiswa', 'organizer' => 'HIMA-SIKC Politeknik Negeri Indramayu', 'year' => '2024, 2025'],
            ['name' => 'Pelatihan Pers', 'organizer' => 'Persatuan Wartawan Indonesia (PWI) Indramayu', 'year' => '2024'],
            ['name' => 'Seminar Teknologi Himpunan Mahasiswa', 'organizer' => 'HIMATIF Politeknik Negeri Indramayu', 'year' => '2023'],
            ['name' => 'Seminar Teknologi Himpunan Mahasiswa', 'organizer' => 'HIMA-SIKC Politeknik Negeri Indramayu', 'year' => '2024, 2025'],
        ];

        foreach ($items as $i => $item) {
            Certificate::create($item + ['sort_order' => $i]);
        }
    }
}
