/*
  Membuat salinan index.html untuk tiap halaman, dengan judul, deskripsi, dan
  gambar pratinjau yang sesuai isinya. Dijalankan otomatis setelah "vite build".

  Kenapa perlu?
  WhatsApp, LinkedIn, Facebook, dan Discord TIDAK menjalankan JavaScript saat
  mengambil pratinjau link. Mereka hanya membaca berkas HTML apa adanya.
  Padahal judul per halaman di website ini dipasang React saat halaman dibuka.
  Akibatnya link halaman project menampilkan pratinjau beranda.

  Yang mereka butuhkan hanya tag di dalam <head>, bukan isi halamannya. Jadi
  tidak perlu merender React di sini — cukup menyalin index.html lalu mengganti
  beberapa barisnya. Hasilnya, misalnya, dist/projects/website-x/index.html.

  Vercel mencari berkas yang benar-benar ada lebih dulu sebelum menerapkan
  aturan di vercel.json, jadi berkas inilah yang dilayani untuk alamat itu.

  Untuk manusia tidak ada yang berubah: begitu React jalan, judul dari React
  yang menang, dan perpindahan halaman tetap tanpa memuat ulang.

  CATATAN: kalau menambah jenis halaman baru, tambahkan juga di daftar
  "halaman" di bawah — kalau tidak, pratinjaunya kembali memakai isi beranda.
*/

import { mkdirSync, readFileSync, writeFileSync } from 'node:fs'
import { dirname, join } from 'node:path'
import { fileURLToPath } from 'node:url'

const frontend = join(dirname(fileURLToPath(import.meta.url)), '..')
const dist = join(frontend, 'dist')

const SITE_URL = 'https://decomahendra.vercel.app'
const GAMBAR_BAWAAN = `${SITE_URL}/og-image.png`

const template = readFileSync(join(dist, 'index.html'), 'utf8')
const portfolio = JSON.parse(readFileSync(join(frontend, 'src/data/portfolio.json'), 'utf8'))

/*
  Gambar pratinjau: 1200x630 adalah ukuran yang diharapkan WhatsApp dan LinkedIn.
  c_pad membuat seluruh gambar terlihat (tidak terpotong), b_auto mengisi
  sisanya dengan warna yang diambil dari gambar itu sendiri.
  Sama seperti cloudinaryImage() di src/data/cloudinary.js.
*/
const gambarPratinjau = (url) =>
  url ? url.replace('/upload/', '/upload/w_1200,h_630,c_pad,b_auto,f_auto,q_auto/') : GAMBAR_BAWAAN

// Deskripsi dipotong di batas kata, bukan di tengah kata.
const ringkas = (teks, maksimal = 155) => {
  const satuBaris = teks.replace(/\s+/g, ' ').trim()
  if (satuBaris.length <= maksimal) return satuBaris

  const potong = satuBaris.slice(0, maksimal)
  return `${potong.slice(0, potong.lastIndexOf(' '))}…`
}

// Tanda kutip dan & harus diubah, kalau tidak atribut HTML-nya rusak.
const aman = (teks) =>
  teks.replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/</g, '&lt;').replace(/>/g, '&gt;')

const halaman = [
  {
    path: 'projects',
    judul: 'Project — Deco Mahendra',
    deskripsi:
      'Kumpulan project yang dikerjakan Deco Mahendra: aplikasi web, teknologi yang dipakai, dan tautan ke kode maupun demo.',
    gambar: GAMBAR_BAWAAN,
  },
  {
    path: 'certificates',
    judul: 'Pelatihan & Sertifikasi — Deco Mahendra',
    deskripsi: 'Daftar pelatihan, seminar, dan sertifikasi yang diikuti Deco Mahendra.',
    gambar: GAMBAR_BAWAAN,
  },
  ...portfolio.projects.map((project) => ({
    path: `projects/${project.slug}`,
    judul: `${project.name} — Deco Mahendra`,
    deskripsi: ringkas(project.description),
    gambar: gambarPratinjau(project.images[0]?.url),
  })),
]

// Mengganti satu tag <meta ...>, baik yang ditulis satu baris maupun beberapa baris.
const gantiMeta = (html, atribut, nama, isi) =>
  html.replace(
    new RegExp(`<meta[^>]*${atribut}="${nama}"[^>]*>`),
    `<meta ${atribut}="${nama}" content="${aman(isi)}" />`,
  )

for (const { path, judul, deskripsi, gambar } of halaman) {
  let html = template

  html = html.replace(/<title>[\s\S]*?<\/title>/, `<title>${aman(judul)}</title>`)
  html = gantiMeta(html, 'name', 'description', deskripsi)

  html = gantiMeta(html, 'property', 'og:url', `${SITE_URL}/${path}`)
  html = gantiMeta(html, 'property', 'og:title', judul)
  html = gantiMeta(html, 'property', 'og:description', deskripsi)
  html = gantiMeta(html, 'property', 'og:image', gambar)
  html = gantiMeta(html, 'property', 'og:image:alt', judul)

  html = gantiMeta(html, 'name', 'twitter:title', judul)
  html = gantiMeta(html, 'name', 'twitter:description', deskripsi)
  html = gantiMeta(html, 'name', 'twitter:image', gambar)

  // Alamat resmi halaman ini, untuk mesin pencari.
  html = html.replace('</head>', `  <link rel="canonical" href="${SITE_URL}/${path}" />\n  </head>`)

  const folder = join(dist, path)
  mkdirSync(folder, { recursive: true })
  writeFileSync(join(folder, 'index.html'), html)
}

/*
  sitemap.xml — daftar alamat halaman untuk mesin pencari.

  Dibuat di sini, bukan ditulis tangan, supaya halaman project baru otomatis
  ikut terdaftar setiap kali data diekspor dan website dibangun ulang.
  Halaman "tidak ditemukan" sengaja tidak dimasukkan.
*/
const alamat = ['', ...halaman.map((h) => h.path)]

const sitemap = `<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
${alamat.map((path) => `  <url><loc>${SITE_URL}/${path}</loc></url>`).join('\n')}
</urlset>
`

writeFileSync(join(dist, 'sitemap.xml'), sitemap)

console.log(`Pratinjau link dibuat untuk ${halaman.length} halaman, sitemap berisi ${alamat.length} alamat.`)
