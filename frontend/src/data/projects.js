import portfolio from './portfolio.json'

/*
  DAFTAR PROJECT

  Sumbernya dari dashboard admin (menu Project), lewat portfolio.json.

  id          = nomor dari database, dipakai sebagai key di React
  slug        = nama versi alamat web: /projects/{slug}
  name        = nama project
  description = penjelasan
  tech        = teknologi yang dipakai
  repo        = link repository, atau null kalau tidak ada
  demo        = link website yang sudah online, atau null
  images      = gambar (slide) berurutan; yang pertama jadi sampul.
                alt boleh null — tampilan menyiapkan teks penggantinya.
*/
export const PROJECTS = portfolio.projects.map((project) => ({
  id: project.id,
  slug: project.slug,
  name: project.name,
  description: project.description,
  tech: project.tech,
  repo: project.repo_url,
  demo: project.demo_url,
  images: project.images.map((image) => ({ url: image.url, alt: image.alt })),
}))
