# Portfolio Deco Mahendra — Frontend

Website portfolio pribadi. Dibuat dengan React + Vite + Tailwind CSS.

Status saat ini: **Phase 6 — Contact + Footer selesai.**

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
│                      lewat alamat, contoh: /favicon.svg
├── src/
│   ├── assets/        Gambar yang dipakai di dalam kode (foto profil, dll)
│   ├── components/
│   │   ├── layout/    Kerangka halaman: Navbar, MobileMenu, MenuToggle,
│   │   │                Footer
│   │   ├── sections/  Isi halaman: Hero, About, Skills, Projects, Contact
│   │   └── ui/        Bata dasar yang dipakai berulang: Container, Section
│   ├── data/          Isi/konten yang dipisah dari tampilan
│                      (navigation, profile, skills, experience,
│                      education, projects, certificates, contact)
│   ├── hooks/         Logika yang bisa dipakai ulang (useActiveSection, dll)
│   ├── App.jsx        Komponen utama - merangkai seluruh halaman
│   ├── main.jsx       Titik mulai aplikasi. Menempelkan App ke index.html
│   └── index.css      Design system: warna, font, ukuran, gaya dasar
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

**Font** — hanya 2 yang diunduh dari internet supaya website tetap ringan:

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
| React Router | Website ini cuma satu halaman. Pindah section pakai link biasa `<a href="#about">`. |
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
| 7 | Responsive + Animation + SEO |
| 8 | Testing — setelah ini website siap dikirim ke recruiter |

Phase 9–14 (Laravel + Admin Dashboard) dikerjakan setelah Phase 1–8 selesai.
