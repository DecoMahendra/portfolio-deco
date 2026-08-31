/*
  TAUTAN KONTAK

  Nomor HP sengaja tidak dimasukkan. Bot pemindai rutin menyisir halaman web
  mencari pola nomor telepon, dan hasilnya spam telepon serta WhatsApp yang
  tidak bisa dihentikan. Email lebih aman dan tetap mudah dijangkau.

  label = jenis kontak, ditampilkan di kolom kiri
  value = teks yang dibaca pengunjung
  href  = alamat tujuan saat diklik.
          Wajib lengkap dengan https:// — kalau tidak, browser menganggapnya
          alamat di dalam website ini sendiri dan tautannya mati.
          mailto: membuka aplikasi email pengunjung.
*/

export const CONTACT_LINKS = [
  {
    label: 'Email',
    value: 'decomhndra28@gmail.com',
    href: 'mailto:decomhndra28@gmail.com',
  },
  {
    label: 'GitHub',
    value: 'github.com/DecoMahendra',
    href: 'https://github.com/DecoMahendra',
  },
  {
    label: 'LinkedIn',
    value: 'linkedin.com/in/deco-mahendra',
    href: 'https://www.linkedin.com/in/deco-mahendra',
  },
]
