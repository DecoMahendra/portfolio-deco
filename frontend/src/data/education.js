import portfolio from './portfolio.json'

/*
  RIWAYAT PENDIDIKAN

  Sumbernya dari dashboard admin (menu Pendidikan), lewat portfolio.json.

  id      = nomor dari database, dipakai sebagai key di React
  school  = nama sekolah atau kampus
  program = jurusan atau program studi
  period  = rentang waktu
*/
export const EDUCATION = portfolio.education.map((item) => ({
  id: item.id,
  school: item.school,
  program: item.program,
  period: item.period,
}))
