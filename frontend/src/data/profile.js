/*
  DATA DIRI

  Untuk mengubah isi Hero atau About, cukup ubah nilai di file ini.
  Kode JSX-nya tidak perlu disentuh.

  Kenapa dipisah ke file sendiri?
  Data ini dipakai di beberapa tempat (Hero, About, nanti Contact dan Footer).
  Di Phase 13 nanti sumbernya diganti jadi API Laravel — kalau sudah terpisah
  seperti ini, cukup ganti sumber datanya tanpa membongkar tampilannya.
*/

export const PROFILE = {
  name: 'Deco Mahendra',

  role: 'Full Stack Developer',

  // Ditampilkan sebagai label kecil di About.
  location: 'Indramayu, Jawa Barat',

  // Label di bagian paling atas Hero, bersebelahan dengan titik hijau berkedip.
  availability: 'Terbuka untuk project freelance',

  // Satu kalimat di bawah judul besar Hero.
  tagline:
    'Full Stack Developer yang membangun website modern, responsif, dan berorientasi pada pengalaman pengguna.',

  // Paragraf untuk section About. Boleh ditambah atau dikurangi jumlahnya —
  // tampilannya menyesuaikan otomatis.
  bio: [
    'Mahasiswa D4 Sistem Informasi Kota Cerdas di Politeknik Negeri Indramayu, dengan ketertarikan dalam membangun aplikasi web modern dari sisi frontend hingga backend.',
    'Saya senang mempelajari teknologi baru, menyelesaikan masalah melalui kode, dan mengembangkan project yang memiliki tampilan menarik serta fungsional.',
  ],

  // Teks pengganti foto untuk pembaca layar dan saat gambar gagal dimuat.
  photoAlt: 'Foto Deco Mahendra',
}
