/*
  DAFTAR KEAHLIAN

  Diambil dari bagian "Kemampuan Utama" di CV, dikelompokkan supaya pembaca
  langsung menangkap luasnya kemampuan tanpa perlu menebak dari nama-nama
  teknologinya.

  Empat tambahan di luar CV, semuanya bisa dibuktikan dari project ini sendiri:
  - Tailwind CSS, Vite, Git, GitHub

  Satu tambahan berdasarkan penalaran: PHP — karena Laravel adalah framework
  PHP, jadi tidak mungkin dipakai tanpa menulis PHP. Ditulis terpisah karena
  banyak lowongan dan sistem penyaring lamaran mencari kata "PHP", bukan "Laravel".

  category = judul kelompok
  items    = daftar teknologi di kelompok itu
*/

export const SKILL_GROUPS = [
  {
    category: 'Pengembangan Web',
    items: ['HTML', 'CSS', 'JavaScript', 'React', 'Laravel', 'Tailwind CSS'],
  },
  {
    category: 'Bahasa Pemrograman',
    items: ['PHP', 'Java', 'Python'],
  },
  {
    category: 'Basis Data & Pengolahan Data',
    items: ['MySQL', 'Pandas', 'NumPy'],
  },
  {
    category: 'Mobile & IoT',
    items: ['Flutter', 'Internet of Things'],
  },
  {
    category: 'Tools',
    items: ['Git', 'GitHub', 'Vite'],
  },
]
