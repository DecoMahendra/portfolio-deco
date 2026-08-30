/*
  DAFTAR PROJECT

  name        = nama project
  description = penjelasan singkat: apa fungsinya, masalah apa yang diselesaikan
  tech        = teknologi yang dipakai
  repo        = link repository GitHub. Isi null kalau tidak ada atau masih privat
  demo        = link website yang sudah online. Isi null kalau belum di-deploy

  Bagian link otomatis menyesuaikan: kalau repo atau demo bernilai null,
  tombolnya tidak ditampilkan.
*/

export const PROJECTS = [
  {
    name: 'Website Portfolio Pribadi',
    description:
      'Website portfolio satu halaman yang dibangun dari nol tanpa template. ' +
      'Memiliki design system sendiri, navigasi yang otomatis menandai bagian ' +
      'yang sedang dibaca, serta dukungan navigasi keyboard dan pembaca layar. ' +
      'Backend Laravel dan dashboard admin sedang dalam rencana pengembangan.',
    tech: ['React', 'Vite', 'Tailwind CSS', 'JavaScript'],
    repo: 'https://github.com/DecoMahendra/portfolio-deco',
    demo: null,
  },
]
