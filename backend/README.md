# Backend — Portfolio Deco Mahendra

API dan admin dashboard untuk website portfolio. Dibuat dengan Laravel + MySQL.

Frontend-nya ada di folder [`../frontend/`](../frontend/) — React + Vite + Tailwind CSS.

Status saat ini: **Phase 9 — Laravel Setup selesai.**

---

## Cara menjalankan

**1. Nyalakan MySQL dulu.**

Buka XAMPP Control Panel, klik **Start** pada MySQL, tunggu sampai hijau.

Ini wajib setiap kali mau mengerjakan backend. MySQL XAMPP tidak menyala
otomatis saat komputer dinyalakan.

**2. Jalankan servernya:**

```bash
composer install     # cukup sekali, saat pertama kali
php artisan serve    # setiap kali mau mulai mengerjakan
```

Lalu buka `http://127.0.0.1:8000`.

Untuk menghentikan server: tekan `Ctrl + C` di terminal.

---

## Daftar perintah

| Perintah | Fungsinya |
|---|---|
| `php artisan serve` | Menjalankan server di komputer sendiri |
| `php artisan migrate` | Menerapkan perubahan struktur tabel ke database |
| `php artisan migrate:status` | Melihat migrasi mana yang sudah dijalankan |
| `php artisan migrate:fresh` | ⚠️ Hapus semua tabel lalu buat ulang — **data hilang** |
| `php artisan tinker` | Mencoba kode PHP langsung, berguna untuk mengecek data |
| `php artisan route:list` | Melihat semua alamat API yang tersedia |

Semua perintah dijalankan dari dalam folder `backend/` ini.

---

## Pengaturan database

Ada di file `.env` (tidak masuk Git karena berisi kata sandi):

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=portfolio_deco
DB_USERNAME=      <- isi sesuai pengaturan MySQL-mu
DB_PASSWORD=      <- isi sesuai pengaturan MySQL-mu
```

> ⚠️ XAMPP secara bawaan memakai pengguna `root` tanpa kata sandi.
> Itu hanya boleh untuk komputer sendiri. Di server sungguhan, buat
> pengguna database khusus dengan kata sandi, dan beri hak akses
> hanya ke database yang memang diperlukan.

Untuk menyiapkan di komputer baru: salin `.env.example` jadi `.env`, lalu
jalankan `php artisan key:generate`.

Databasenya sendiri dibuat manual sekali saja:

```sql
CREATE DATABASE portfolio_deco
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

---

## Kalau muncul error koneksi

```
SQLSTATE[HY000] [2002] No connection could be made
because the target machine actively refused it
```

Artinya **MySQL belum dinyalakan** — bukan kode yang rusak. Nyalakan lewat
XAMPP Control Panel.

Beda dengan pesan lain:

| Pesan | Artinya |
|---|---|
| `refused` | MySQL belum jalan |
| `Access denied` | Nama pengguna atau kata sandi salah |
| `Unknown database` | Nama database di `.env` keliru |

---

## Isi folder

```
backend/
├── app/
│   ├── Http/Controllers/   Menangani permintaan yang masuk
│   ├── Models/             Perwakilan tabel database dalam bentuk kode
│   └── Providers/          Pengaturan yang dijalankan saat aplikasi mulai
├── config/                 Berkas pengaturan (database, mail, cache, dll)
├── database/
│   ├── migrations/         Riwayat perubahan struktur tabel
│   ├── factories/          Pembuat data contoh untuk keperluan uji
│   └── seeders/            Pengisi data awal
├── public/                 Satu-satunya folder yang bisa diakses dari luar
├── resources/views/        Halaman HTML (Blade)
├── routes/                 Daftar alamat: web.php dan console.php
├── storage/                Berkas unggahan, cache, dan log
├── .env                    Pengaturan rahasia — TIDAK masuk Git
└── .env.example            Contoh pengaturan tanpa nilai rahasia
```

---

## Rencana selanjutnya

| Phase | Isi |
|---|---|
| ~~9~~ | ~~Laravel Setup~~ ✅ selesai |
| 10 | Database — tabel untuk profil, skill, project, sertifikat |
| 11 | API — alamat yang dibaca frontend React |
| 12 | Admin Dashboard — mengelola isi tanpa mengedit kode |
| 13 | Hubungkan React + Laravel |
| 14 | Testing |
