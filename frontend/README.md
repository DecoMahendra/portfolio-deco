# Portfolio Deco Mahendra — Frontend

Website portfolio pribadi. Dibuat dengan React + Vite + Tailwind CSS.

Status saat ini: **online, isinya diambil dari dashboard admin.**

## Mengubah isi website

Teks, skill, pengalaman, project, dan sertifikat **tidak** diubah di kode,
melainkan lewat dashboard admin di [`../backend/`](../backend/). Setelah itu
jalankan `php artisan portfolio:export` di folder backend — perintah itu
menulis ulang `src/data/portfolio.json` — lalu commit dan push.

Yang masih diubah langsung di kode: menu navbar (`src/data/navigation.js`),
tautan kontak (`src/data/contact.js`), dan foto profil (`src/assets/`).

---

## Cara menjalankan

Buka terminal di folder ini, lalu ketik:

```bash
npm install     # cukup sekali saja, saat pertama kali
npm run dev     # setiap kali mau mulai mengerjakan
```

Setelah itu buka `http://localhost:5173` di browser.

Untuk menghentikan server: tekan `Ctrl + C` di terminal.

---

## Daftar perintah

| Perintah | Fungsinya |
|---|---|
| `npm run dev` | Menjalankan website di komputer sendiri. Setiap file yang disimpan langsung terlihat perubahannya di browser. |
| `npm run build` | Membuat versi final yang siap diunggah ke internet. Hasilnya masuk ke folder `dist/`. |
| `npm run preview` | Mencoba hasil `build` di komputer sendiri, untuk memastikan versi finalnya benar-benar jalan. |
| `npm run lint` | Memeriksa kode dari kesalahan penulisan yang umum. |

---

## Isi folder

```
frontend/
├── public/            File yang disalin apa adanya. Bisa diakses langsung
│   │                  lewat alamat, contoh: /favicon.svg
│   └── fonts/         Berkas font Inter & Space Grotesk (woff2)
├── src/
│   ├── assets/        Gambar yang dipakai di dalam kode (foto profil, dll)
│   ├── components/
│   │   ├── layout/    Kerangka semua halaman: Layout, Navbar, MobileMenu,
│   │   │                MenuToggle, Footer
│   │   ├── sections/  Isi beranda: Hero, About, Skills, Projects,
│   │   │                Certificates, Contact
│   │   └── ui/        Bata dasar yang dipakai berulang: Container, Section,
│   │                    ProjectCard, CertificateCard, Marquee, ImageCarousel,
│   │                    BackLink
│   ├── pages/         Satu berkas per halaman: HomePage, ProjectsPage,
│   │                    ProjectDetailPage, CertificatesPage, NotFoundPage
│   ├── data/          Isi/konten yang dipisah dari tampilan
│                      portfolio.json = hasil ekspor dari dashboard admin
│                      profile, skills, experience, education, projects,
│                      certificates = penerjemah dari portfolio.json
│                      navigation, contact = ditulis langsung di sini
│   ├── hooks/         Logika yang bisa dipakai ulang (useActiveSection, dll)
│   ├── App.jsx        Komponen utama - merangkai seluruh halaman
│   ├── main.jsx       Titik mulai aplikasi. Menempelkan App ke index.html
│   └── index.css      Design system: warna, font, ukuran, gaya dasar
├── scripts/           Dijalankan setelah build, bukan bagian dari website:
│                        prerender-meta.mjs (pratinjau link per halaman)
├── vercel.json        Aturan Vercel: folder hasil build + alamat dalam
│                        tetap memuat website
├── index.html         Kerangka HTML. Isi <head> untuk SEO & font ada di sini
├── vite.config.js     Pengaturan Vite (plugin React & Tailwind didaftarkan di sini)
└── package.json       Daftar library yang dipakai project ini
```

---

## Design system (Phase 2)

Semua warna dan font didaftarkan **satu kali** di `src/index.css` di dalam blok `@theme`.
Setelah didaftarkan, Tailwind otomatis membuat class-nya.

| Token | Warna | Class Tailwind | Dipakai untuk |
|---|---|---|---|
| `--color-page` | `#09090B` | `bg-page` | Latar halaman |
| `--color-surface` | `#101014` | `bg-surface` | Kartu / panel |
| `--color-raised` | `#17171C` | `bg-raised` | Elemen di atas kartu |
| `--color-line` | `#26262B` | `border-line` | Garis pembatas |
| `--color-line-soft` | `#1B1B20` | `border-line-soft` | Garis pembatas samar |
| `--color-heading` | `#FAFAFA` | `text-heading` | Judul |
| `--color-body` | `#A1A1AA` | `text-body` | Paragraf |
| `--color-faint` | `#6B6B76` | `text-faint` | Teks pendukung |
| `--color-accent` | `#D4FF3F` | `text-accent` / `bg-accent` | Aksen lime |
| `--color-accent-deep` | `#A8CC2A` | `bg-accent-deep` | Aksen saat hover |

**Font** — 2 font, disimpan sendiri di `public/fonts/` (bukan dari Google Fonts).
Alasannya ada di komentar `@font-face` dalam `src/index.css`:

| Token | Font | Class | Dipakai untuk |
|---|---|---|---|
| `--font-display` | Space Grotesk | `font-display` | Judul |
| `--font-sans` | Inter | (default `<body>`) | Paragraf & tombol |
| bawaan Tailwind | font mono komputer | `font-mono` | Label kecil |

**Ukuran teks** memakai `clamp()`, jadi ikut menyesuaikan lebar layar otomatis
tanpa perlu diatur per-breakpoint:

| Class | Untuk |
|---|---|
| `text-display` | Judul hero |
| `text-title` | Judul section |
| `text-eyebrow` | Label kecil di atas judul |

> Mau ganti warna aksen dari lime ke warna lain? Ubah satu baris `--color-accent`
> di `src/index.css`. Seluruh website ikut berubah.

---

## Halaman dan alamatnya

Website ini beberapa halaman, diatur React Router (lihat `src/App.jsx`):

| Alamat | Halaman |
|---|---|
| `/` | Beranda — semua section jadi satu |
| `/projects` | Daftar semua project |
| `/projects/{slug}` | Detail satu project: galeri gambar, teknologi, tautan |
| `/certificates` | Daftar pelatihan & sertifikasi |
| alamat lain | Halaman "tidak ditemukan" |

Tiga hal yang mudah terlupa saat menambah halaman baru:

- **Link ke section beranda ditulis `/#about`**, bukan `#about`. Tanpa garis
  miring, dari halaman lain ia menuju `/projects#about` yang tidak ada.
- **`vercel.json`** berisi dua hal: aturan supaya membuka alamat dalam secara
  langsung (misalnya dari link yang dibagikan) tetap memuat website, dan
  penyebutan folder hasil build (`dist`). Bagian kedua itu WAJIB: begitu
  `vercel.json` ada, Vercel berhenti menebak sendiri jenis project-nya dan
  mencari folder bernama `build` — kalau tidak disebutkan, semua deployment
  gagal dengan pesan *No Output Directory named "build" found*.
- **Alamat kanonik** ditulis di masing-masing halaman, bukan di `index.html`.
  Kalau ditulis sekali di `index.html`, semua halaman akan mengaku sebagai
  beranda dan Google bisa berhenti mengindeks halaman lainnya.

### Pratinjau saat link dibagikan

WhatsApp, LinkedIn, Facebook, dan Discord **tidak menjalankan JavaScript** saat
mengambil pratinjau link — mereka hanya membaca berkas HTML apa adanya. Padahal
judul per halaman di website ini dipasang React saat halaman dibuka.

Karena itu `npm run build` menjalankan `scripts/prerender-meta.mjs`, yang
membuat salinan `index.html` untuk tiap halaman dengan judul, deskripsi, dan
gambar pratinjau yang sesuai — misalnya `dist/projects/nama-project/index.html`
memakai nama dan gambar sampul project itu. Vercel memeriksa berkas yang
benar-benar ada lebih dulu, jadi berkas itulah yang dibaca aplikasi chat.

Untuk manusia tidak ada yang berubah: begitu React jalan, judul dari React yang
menang, dan perpindahan halaman tetap tanpa memuat ulang.

> **Kalau menambah jenis halaman baru, tambahkan juga di daftar `halaman` di
> dalam `scripts/prerender-meta.mjs`.** Kalau terlupa, pratinjau halaman itu
> kembali memakai isi beranda — dan itu tidak terlihat saat `npm run dev`.

---

## ⚠️ Catatan penting: Tailwind CSS versi 4

Project ini memakai **Tailwind CSS v4**, bukan v3.

Perbedaannya dengan tutorial lama yang mungkin kamu temukan di YouTube/blog:

| | Tailwind v3 (tutorial lama) | Tailwind v4 (yang dipakai di sini) |
|---|---|---|
| File konfigurasi | Ada `tailwind.config.js` | **Tidak ada** |
| File PostCSS | Ada `postcss.config.js` | **Tidak ada** |
| Cara mengaktifkan | 3 baris `@tailwind base;` dst. | Satu baris `@import "tailwindcss";` |
| Menentukan warna | Di dalam `tailwind.config.js` | Di dalam CSS, pakai blok `@theme` |

**Kalau menemukan tutorial yang menyuruh membuat `tailwind.config.js`, itu tutorial v3.**
Setupnya tidak akan cocok dengan project ini.

Dokumentasi resmi v4: https://tailwindcss.com/docs

---

## Yang TIDAK dipakai di project ini (disengaja)

| Library | Alasan tidak dipakai |
|---|---|
| Axios | Browser sudah punya `fetch()` bawaan dengan fungsi yang sama. |
| Framer Motion | Ukurannya besar. Animasi yang dibutuhkan cukup dengan CSS + IntersectionObserver. |

---

## Rencana selanjutnya

| Phase | Isi |
|---|---|
| ~~1~~ | ~~Setup~~ ✅ selesai |
| ~~2~~ | ~~Design System + Navbar~~ ✅ selesai |
| ~~3~~ | ~~Hero + About~~ ✅ selesai |
| ~~4~~ | ~~Skills + Experience~~ ✅ selesai |
| ~~5~~ | ~~Projects + Certificates~~ ✅ selesai |
| ~~6~~ | ~~Contact + Footer~~ ✅ selesai |
| ~~7~~ | ~~Responsive + Animation + SEO~~ ✅ selesai |
| ~~8~~ | ~~Testing~~ ✅ selesai |

Selanjutnya: **Phase 14 — Testing** (Lighthouse, navigasi keyboard, tampilan di HP).
