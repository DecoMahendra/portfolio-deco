import portfolio from './portfolio.json'

/*
  DATA DIRI

  Sumbernya dari dashboard admin:
  dashboard -> database -> php artisan portfolio:export -> portfolio.json
  Untuk mengubah isi Hero, About, atau Footer, ubah lewat dashboard admin,
  bukan di file ini — isi file ini ikut berubah setiap kali ekspor.

  File ini hanya menerjemahkan bentuk data dari database ke bentuk yang
  dipakai komponen, supaya komponennya tidak perlu diubah.
*/
const { profile } = portfolio

export const PROFILE = {
  name: profile.name,
  role: profile.role,
  location: profile.location,
  availability: profile.availability,
  tagline: profile.tagline,

  /*
    Di database bio berupa satu teks, paragrafnya dipisah baris kosong.
    \r? : isian dari form di Windows memakai akhir baris \r\n, bukan \n.
    filter: buang paragraf kosong kalau ada baris kosong berlebih.
  */
  bio: profile.bio.split(/\r?\n\s*\r?\n/).filter(Boolean),

  photoAlt: profile.photo_alt,
}
