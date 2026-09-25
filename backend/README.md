# Backend — Portfolio Deco Mahendra

Dashboard admin dan API untuk website portfolio. Dibuat dengan Laravel + MySQL.

Frontend-nya ada di folder [`../frontend/`](../frontend/) — React + Vite + Tailwind CSS.

Status saat ini: **Phase 13 — Hubungkan React + Laravel selesai.**
Website membaca isi dari dashboard ini lewat berkas ekspor. Backend belum
online — lihat [Deploy](#deploy-ditunda).

---

## Gambaran singkat

```
Dashboard admin (laptop)  ──►  Database MySQL (Aiven, online)
        │                          ▲
        │ unggah gambar            │ data
        ▼                          │
   Cloudinary (online)     php artisan portfolio:export
                                   │
                                   ▼
                  frontend/src/data/portfolio.json  ──►  git push  ──►  Vercel
```

- **Data** tersimpan di Aiven, bukan di laptop — aman kalau laptop rusak.
- **Gambar** tersimpan di Cloudinary, yang juga mengecilkannya otomatis.
- **Website** tidak bergantung pada server yang menyala: isinya ikut dibangun
  bersama React, jadi tetap tampil walaupun Aiven sedang mati.

---

## Memperbarui isi website

Ini yang paling sering dikerjakan:

1. **Pastikan database Aiven menyala** — lihat [di bawah](#database-online-aiven)
2. Jalankan dashboard: `php artisan serve`, buka `http://127.0.0.1:8000`
3. Ubah isi lewat dashboard
4. Tulis ulang berkas data untuk frontend:
   ```bash
   php artisan portfolio:export
   ```
5. Commit dan push `frontend/src/data/portfolio.json` — Vercel membangun
   ulang website dalam 1–2 menit

Langkah 4–5 wajib. Tanpa itu, perubahan di dashboard **tidak** muncul di website.

---

## Cara menjalankan (pertama kali)

**1. Pasang dependensi:**

```bash
composer install               # paket PHP
npm install && npm run build   # Tailwind untuk tampilan dashboard
```

**2. Siapkan `.env`:** salin `.env.example` jadi `.env`, jalankan
`php artisan key:generate`, lalu isi bagian database (Aiven) dan Cloudinary.
Nilainya ada di dashboard masing-masing layanan.

**3. Buat akun admin:**

```bash
php artisan admin:create
```

**4. Jalankan:**

```bash
php artisan serve
```

Buka `http://127.0.0.1:8000` — otomatis diarahkan ke halaman login.
Untuk menghentikan server: tekan `Ctrl + C`.

Kalau sedang mengubah tampilan dashboard (file `.blade.php` atau `app.css`),
jalankan `npm run build` lagi supaya CSS-nya ikut diperbarui.

---

## Daftar perintah

| Perintah | Fungsinya |
|---|---|
| `php artisan serve` | Menjalankan dashboard di komputer sendiri |
| `php artisan portfolio:export` | Menulis isi database ke `frontend/src/data/portfolio.json` |
| `php artisan admin:create` | Membuat akun admin — satu-satunya cara, tidak ada halaman daftar |
| `php artisan migrate` | Menerapkan perubahan struktur tabel ke database |
| `php artisan migrate:status` | Melihat migrasi mana yang sudah dijalankan |
| `php artisan migrate:fresh` | ⚠️ Hapus semua tabel lalu buat ulang — **data hilang** |
| `php artisan db:seed` | ⚠️ Mengisi ulang tabel dengan data awal — **menimpa isi yang ada** |
| `php artisan config:clear` | Wajib setelah mengubah `.env` |
| `php artisan tinker` | Mencoba kode PHP langsung, berguna untuk mengecek data |
| `php artisan route:list` | Melihat semua alamat yang tersedia |
| `npm run build` | Membangun ulang CSS dashboard setelah mengubah tampilan |

Semua perintah dijalankan dari dalam folder `backend/` ini.

---

## Database online (Aiven)

Database MySQL gratis di [Aiven](https://console.aiven.io), service `portfolio-db`.

**Aiven mematikan service gratis yang lama tidak dipakai.** Tandanya: perintah
apa pun yang menyentuh database gagal dengan pesan `No such host is known`.
Datanya **tidak hilang** — nyalakan lagi lewat console Aiven → service
`portfolio-db` → **Power on**, tunggu sampai *Running* (beberapa menit).
Aiven biasanya mengirim email peringatan sebelum mematikan.

Koneksinya wajib SSL. Sertifikat CA-nya ada di `storage/certs/ca.pem` dan
sengaja ikut masuk Git: sertifikat bukan rahasia, isinya hanya identitas
server. Yang rahasia adalah password di `.env`.

### Beralih ke MySQL XAMPP

`.env` punya dua blok database: **A** (XAMPP) dan **B** (Aiven). Yang aktif
adalah yang tidak diawali `#`. Setelah berpindah, jalankan
`php artisan config:clear`.

XAMPP berguna untuk mencoba-coba tanpa menyentuh data asli. Kalau baru
pertama kali, buat databasenya dulu:

```sql
CREATE DATABASE portfolio_deco CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

lalu `php artisan migrate --seed`.

> ⚠️ XAMPP secara bawaan memakai pengguna `root` tanpa kata sandi.
> Itu hanya boleh untuk komputer sendiri.

---

## Gambar (Cloudinary)

Gambar project dan sertifikat diunggah lewat dashboard ke
[Cloudinary](https://console.cloudinary.com), bukan disimpan di repository.
Database hanya mencatat alamat gambarnya (`url`) dan namanya di Cloudinary
(`public_id`, dipakai saat menghapus).

- Batas unggah **5 MB**, format jpg/png/webp
- Menghapus gambar, project, atau sertifikat lewat dashboard ikut menghapus
  filenya di Cloudinary
- Ukuran tampil diatur lewat alamat: `Cloudinary::resized($url, 600)` meminta
  versi lebar 600px dalam format yang paling ringan untuk browser pengunjung.
  Gambar 150 KB biasanya jadi ±11 KB.

Kodenya di `app/Services/Cloudinary.php` — memakai HTTP client bawaan
Laravel, tanpa library tambahan. Kuncinya ada di `.env`:
`CLOUDINARY_CLOUD_NAME`, `CLOUDINARY_API_KEY`, `CLOUDINARY_API_SECRET`.

---

## Kalau muncul error koneksi

| Pesan | Artinya | Yang dilakukan |
|---|---|---|
| `No such host is known` | Database Aiven sedang dimatikan | Power on di console Aiven |
| `actively refused it` | MySQL XAMPP belum dinyalakan | Start MySQL di XAMPP |
| `Access denied` | Nama pengguna atau kata sandi salah | Cek `.env` |
| `Unknown database` | Nama database di `.env` keliru | Cek `DB_DATABASE` |
| `Cannot connect to MySQL using SSL` | Sertifikat tidak ditemukan | Cek `MYSQL_ATTR_SSL_CA` di `.env` |

---

## Struktur database

Delapan tabel:

| Tabel | Isi |
|---|---|
| `profiles` | Data diri — 1 baris |
| `skill_groups` | Kelompok keahlian |
| `skills` | Keahlian, menunjuk ke `skill_groups` |
| `experiences` | Riwayat pengalaman |
| `education` | Riwayat pendidikan |
| `projects` | Karya — `tech` berupa JSON, `slug` untuk alamat halaman di frontend |
| `project_images` | Gambar project (slide), menunjuk ke `projects` |
| `certificates` | Pelatihan & sertifikasi, dengan satu gambar opsional |

Yang perlu diketahui:

- **Menghapus induk ikut menghapus anaknya**: kelompok skill → skill-nya,
  project → gambarnya (`cascadeOnDelete`).
- Tabel daftar punya kolom **`sort_order`** untuk urutan tampil, tidak
  bergantung pada `id`.
- **`slug`** dibuat otomatis dari nama project kalau dikosongkan di form,
  dan harus unik.

Struktur lengkapnya di `database/migrations/`, data awalnya di
`database/seeders/PortfolioSeeder.php`.

---

## API

```
GET /api/portfolio
```

Satu alamat untuk semua data. Jawabannya JSON dengan enam kunci:

```json
{
  "profile":      { "name": "...", "role": "...", "bio": "...", ... },
  "skills":       [ { "name": "Pengembangan Web", "skills": [ { "name": "HTML" }, ... ] }, ... ],
  "experiences":  [ { "role": "...", "company": "...", "period": "...", "description": "..." }, ... ],
  "education":    [ { "school": "...", "program": "...", "period": "..." }, ... ],
  "projects":     [ { "name": "...", "slug": "...", "tech": [ ... ], "repo_url": "...", "demo_url": null,
                      "images": [ { "url": "...", "alt": null }, ... ] }, ... ],
  "certificates": [ { "name": "...", "organizer": "...", "year": "...", "image_url": null }, ... ]
}
```

Semua daftar sudah terurut sesuai `sort_order`.

Isi `portfolio.json` hasil ekspor **sama persis** dengan jawaban API — keduanya
disusun oleh satu kelas yang sama, `app/Support/PortfolioData.php`. Jadi kalau
suatu saat frontend beralih membaca API, bentuk datanya tidak berubah.

Hanya situs yang terdaftar di `FRONTEND_URL` (`.env`) yang boleh memanggil API
ini dari browser (CORS, `config/cors.php`).

---

## Dashboard admin

Alamat: `/admin`, wajib login.

| Halaman | Yang bisa dilakukan |
|---|---|
| Profil | Ubah data diri |
| Skill | Kelompok skill dan skill di dalamnya |
| Pengalaman, Pendidikan, Sertifikat | Daftar → tambah → ubah → hapus |
| Project | Sama, ditambah gambar: unggah beberapa sekaligus (tarik-lepas), atur urutan dan teks alternatif |

Yang perlu diketahui:

- **Akun** hanya bisa dibuat lewat `php artisan admin:create`.
- **Login** dibatasi 5 percobaan per menit per alamat IP.
- **Urutan tampil** mulai dari 1. Menyimpan di posisi yang sudah terisi
  menggeser item lain ke bawah; menghapus merapatkan urutan. Logikanya di
  `app/Models/Concerns/HasSortOrder.php`.
- **Nama kelompok skill** tidak boleh kembar. **Nama skill** tidak boleh kembar
  di dalam satu kelompok, tapi boleh sama di kelompok berbeda.
- **Gambar project** tersimpan saat menekan Simpan; menghapus gambar langsung
  terjadi tanpa perlu Simpan.
- Pesan validasi masih berbahasa Inggris (bawaan Laravel).

---

## Deploy (ditunda)

Backend belum online. Semua persiapannya sudah ada dan sudah diuji di hosting
sungguhan, tinggal menunggu hosting yang cocok.

**Kenapa ditunda:** hosting gratis yang layak untuk Laravel meminta kartu
kredit (Render, Koyeb, Fly.io). Back4app gratis tanpa kartu sudah dicoba dan
berhasil jalan, tapi container-nya hanya hidup sebentar setiap deploy lalu
alamatnya hangus — tidak bisa dipakai sebagai backend tetap.

**Yang sudah siap:**

- `Dockerfile` + `docker-start.sh` — paket 140 MB, menjalankan migrasi dan
  cache saat start
- `config/cors.php`, `trustProxies`, paksa HTTPS di production
- Database Aiven dengan SSL

**Environment variable di hosting nanti:**

| Key | Nilai |
|---|---|
| `APP_ENV` / `APP_DEBUG` | `production` / `false` |
| `APP_KEY` | dari `.env` |
| `LOG_CHANNEL` / `LOG_LEVEL` | `stderr` / `error` |
| `DB_*` | dari blok Aiven di `.env` |
| `MYSQL_ATTR_SSL_CA` | `storage/certs/ca.pem` |
| `SESSION_DRIVER` / `SESSION_SECURE_COOKIE` | `database` / `true` |
| `FRONTEND_URL` | `https://decomahendra.vercel.app` |
| `CLOUDINARY_*` | dari `.env` |

Setelah backend online, frontend bisa membaca API langsung supaya perubahan di
dashboard langsung tampil tanpa ekspor + push.

---

## Isi folder

```
backend/
├── app/
│   ├── Console/Commands/   Perintah buatan sendiri: admin:create, portfolio:export
│   ├── Http/Controllers/   Menyusun jawaban untuk tiap alamat (API dan dashboard)
│   ├── Models/             Perwakilan tabel database dalam bentuk kode
│   ├── Models/Concerns/    Trait yang dipakai bersama model (HasSortOrder)
│   ├── Providers/          Pengaturan saat aplikasi mulai (paksa HTTPS)
│   ├── Services/           Jembatan ke layanan luar (Cloudinary)
│   └── Support/            Penyusun data portfolio untuk API dan ekspor
├── config/                 Berkas pengaturan (database, cors, services, dll)
├── database/
│   ├── migrations/         Riwayat perubahan struktur tabel
│   └── seeders/            Pengisi data awal
├── public/                 Satu-satunya folder yang bisa diakses dari luar
├── resources/
│   ├── css/, js/           Sumber CSS dan JS dashboard, dibangun oleh Vite
│   └── views/              Halaman dashboard (Blade): layouts/, auth/, admin/, components/
├── routes/                 Daftar alamat: api.php, web.php, console.php
├── storage/certs/ca.pem    Sertifikat SSL database Aiven
├── Dockerfile              Resep paket untuk hosting
├── docker-start.sh         Yang dijalankan saat paket dinyalakan di hosting
├── .env                    Pengaturan rahasia — TIDAK masuk Git
└── .env.example            Contoh pengaturan tanpa nilai rahasia
```

---

## Rencana selanjutnya

| Phase | Isi |
|---|---|
| ~~9–12~~ | ~~Laravel, Database, API, Admin Dashboard~~ ✅ selesai |
| ~~13~~ | ~~Hubungkan React + Laravel~~ ✅ selesai (lewat ekspor) |
| ~~Media & Galeri~~ | ~~Halaman project dan sertifikat di frontend, galeri gambar~~ ✅ selesai |
| 14 | Testing |
