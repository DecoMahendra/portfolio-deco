# Portfolio Pribadi — Deco Mahendra

🔗 **[decomahendra.vercel.app](https://decomahendra.vercel.app)**

Website portfolio pribadi untuk personal branding sebagai Full Stack Developer.

## Isi repository ini

| Folder | Isi | Status |
|---|---|---|
| `frontend/` | Website portfolio — React + Vite + Tailwind CSS | ✅ Online, isinya dari dashboard admin |
| `backend/` | Dashboard admin + API — Laravel | ✅ Jalan di laptop · online ditunda |

## Cara menjalankan

**Frontend** — website portfolio:

```bash
cd frontend
npm install
npm run dev
```

Lalu buka `http://localhost:5173`.

**Backend** — dashboard admin untuk mengubah isi website:

```bash
cd backend
composer install && npm install && npm run build   # cukup sekali
php artisan admin:create                           # cukup sekali, buat akun admin
php artisan serve
```

Lalu buka `http://127.0.0.1:8000`. Database-nya online di Aiven, jadi tidak
perlu XAMPP — tapi kalau lama tidak dipakai, Aiven mematikannya dan harus
dinyalakan lagi lewat console Aiven.

## Memperbarui isi website

1. Ubah isi lewat dashboard admin
2. `php artisan portfolio:export` (di folder `backend`)
3. Commit dan push — Vercel membangun ulang website otomatis

Detail dan penanganan masalah: [backend/README.md](backend/README.md#memperbarui-isi-website).

Penjelasan lengkap: [frontend/README.md](frontend/README.md) dan
[backend/README.md](backend/README.md).

## Teknologi

**Frontend:** React · Vite · Tailwind CSS · Vercel
**Backend:** Laravel · MySQL (Aiven) · Cloudinary

## Progress

**BAGIAN 1 — Portfolio React**
- [x] Phase 1 — Setup
- [x] Phase 2 — Design System + Navbar
- [x] Phase 3 — Hero + About
- [x] Phase 4 — Skills + Experience
- [x] Phase 5 — Projects + Certificates
- [x] Phase 6 — Contact + Footer
- [x] Phase 7 — Responsive + Animation + SEO
- [x] Phase 8 — Testing

**BAGIAN 2 — Laravel + Admin Dashboard**
- [x] Phase 9 — Laravel Setup
- [x] Phase 10 — Database
- [x] Phase 11 — API
- [x] Phase 12 — Admin Dashboard
- [x] Phase 13 — Hubungkan React + Laravel
- [ ] Media & Galeri — halaman project & sertifikat, galeri gambar
- [ ] Phase 14 — Testing
