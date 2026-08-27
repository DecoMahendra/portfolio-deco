/*
  DAFTAR MENU NAVBAR

  Semua isi menu dikumpulkan di satu file supaya kalau mau menambah,
  menghapus, atau mengubah urutan menu, cukup ubah array di bawah ini.
  Navbar (desktop maupun mobile) otomatis ikut berubah.

  id    = harus SAMA PERSIS dengan id section di halaman (contoh: <section id="about">)
          Ini yang membuat link "#about" meluncur ke section About.
  label = tulisan yang dilihat pengunjung.
*/

export const NAV_ITEMS = [
  { id: 'about', label: 'About' },
  { id: 'skills', label: 'Skills' },
  { id: 'projects', label: 'Projects' },
  { id: 'services', label: 'Services' },
  { id: 'contact', label: 'Contact' },
]

/*
  Daftar id section yang dipantau untuk menandai menu aktif.
  'home' ikut dipantau walaupun tidak muncul sebagai menu,
  supaya saat pengunjung ada di bagian paling atas, tidak ada menu yang menyala.

  Dibuat sebagai konstanta di luar komponen (bukan dibuat ulang setiap render)
  supaya React tidak menjalankan ulang pemantauan scroll tanpa perlu.
*/
export const SECTION_IDS = ['home', ...NAV_ITEMS.map((item) => item.id)]
