import portfolio from './portfolio.json'

/*
  RIWAYAT PENGALAMAN

  Sumbernya dari dashboard admin (menu Pengalaman), lewat portfolio.json.
  Urutannya mengikuti yang diatur di sana.

  id          = nomor dari database, dipakai sebagai key di React
  role        = posisi atau peran
  company     = nama perusahaan, instansi, atau organisasi
  period      = rentang waktu
  description = apa yang dikerjakan
*/
export const EXPERIENCE = portfolio.experiences.map((item) => ({
  id: item.id,
  role: item.role,
  company: item.company,
  period: item.period,
  description: item.description,
}))
