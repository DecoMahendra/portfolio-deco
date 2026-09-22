import portfolio from './portfolio.json'

/*
  DAFTAR KEAHLIAN

  Sumbernya dari dashboard admin (menu Skill), lewat portfolio.json.
  Urutan kelompok dan urutan skill di dalamnya mengikuti yang diatur di sana.

  id       = nomor dari database, dipakai sebagai key di React
  category = judul kelompok
  items    = daftar nama skill di kelompok itu
*/
export const SKILL_GROUPS = portfolio.skills.map((group) => ({
  id: group.id,
  category: group.name,
  items: group.skills.map((skill) => skill.name),
}))
