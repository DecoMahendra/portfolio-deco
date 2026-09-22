import portfolio from './portfolio.json'

/*
  PELATIHAN & SERTIFIKASI

  Sumbernya dari dashboard admin (menu Sertifikat), lewat portfolio.json.

  id        = nomor dari database, dipakai sebagai key di React
  name      = nama pelatihan, seminar, atau kegiatan
  organizer = penyelenggaranya
  year      = tahun, boleh lebih dari satu (contoh: '2024, 2025')
*/
export const CERTIFICATES = portfolio.certificates.map((item) => ({
  id: item.id,
  name: item.name,
  organizer: item.organizer,
  year: item.year,
}))
