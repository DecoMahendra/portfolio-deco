import portfolio from './portfolio.json'

/*
  DAFTAR PROJECT

  Sumbernya dari dashboard admin (menu Project), lewat portfolio.json.

  id          = nomor dari database, dipakai sebagai key di React
  name        = nama project
  description = penjelasan singkat
  tech        = teknologi yang dipakai
  repo        = link repository, atau null kalau tidak ada
  demo        = link website yang sudah online, atau null

  Nama repo/demo dipertahankan (di database: repo_url/demo_url) supaya
  komponen Projects tidak perlu diubah. Kalau bernilai null, tombolnya
  otomatis tidak ditampilkan.
*/
export const PROJECTS = portfolio.projects.map((project) => ({
  id: project.id,
  name: project.name,
  description: project.description,
  tech: project.tech,
  repo: project.repo_url,
  demo: project.demo_url,
}))
