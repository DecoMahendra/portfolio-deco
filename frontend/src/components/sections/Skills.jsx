import Section from '../ui/Section'
import { EDUCATION } from '../../data/education'
import { EXPERIENCE } from '../../data/experience'
import { SKILL_GROUPS } from '../../data/skills'

/*
  Skills — berisi tiga bagian dalam satu section: keahlian, pengalaman, pendidikan.

  Ketiganya digabung di sini karena navbar hanya punya satu menu "Skills".
  Memisahnya jadi section terpisah berarti harus menambah menu baru, dan itu
  mengubah navigasi yang sudah berjalan.

  Isinya diambil dari src/data/skills.js, experience.js, dan education.js.
*/
function Skills() {
  return (
    <Section
      id="skills"
      eyebrow="02 — Skills"
      title="Keahlian & latar belakang"
      className="border-t border-line-soft"
    >
      {/* ---------- BAGIAN 1: KEAHLIAN ---------- */}
      {/* Disusun berbaris, bukan berbentuk kartu.

          Alasannya: jumlah isi tiap kelompok tidak sama — "Pengembangan Web"
          punya enam, "Mobile & IoT" cuma dua. Di dalam kartu, kelompok yang
          isinya sedikit menyisakan ruang kosong dan terlihat belum jadi.
          Dengan susunan berbaris, panjang yang berbeda-beda justru terlihat wajar.

          Lebar kolom kirinya (11rem) sengaja sama dengan bagian Pengalaman dan
          Pendidikan di bawah, supaya seluruh section punya satu garis yang lurus. */}
      <ul>
        {SKILL_GROUPS.map((group) => (
          <li
            key={group.category}
            className="grid gap-3 border-t border-line-soft py-6 md:grid-cols-[11rem_1fr] md:gap-10"
          >
            {/* h3 karena judul section-nya (h2) sudah dipakai oleh Section.
                Urutan heading tidak boleh melompat — ini yang dipakai
                pembaca layar untuk menavigasi halaman. */}
            <h3 className="font-mono text-eyebrow uppercase tracking-[0.18em] text-accent md:pt-2">
              {group.category}
            </h3>

            <ul className="flex flex-wrap gap-2">
              {group.items.map((item) => (
                <li
                  key={item}
                  className="rounded-full border border-line bg-surface px-4 py-1.5 text-sm text-body"
                >
                  {item}
                </li>
              ))}
            </ul>
          </li>
        ))}
      </ul>

      {/* ---------- BAGIAN 2: PENGALAMAN ---------- */}
      <div className="mt-20">
        <h3 className="font-mono text-eyebrow uppercase tracking-[0.22em] text-faint">
          Pengalaman
        </h3>

        {/* <ol> dipakai karena urutannya bermakna: dari yang terbaru ke terlama. */}
        <ol className="mt-6">
          {EXPERIENCE.map((item) => (
            /* Key digabung dari nama tempat dan periode supaya tetap unik
               walau kamu pernah berada di tempat yang sama dua kali —
               seperti dua jabatan berbeda di HIMA-SIKC. */
            <li
              key={`${item.company} ${item.period}`}
              className="grid gap-3 border-t border-line-soft py-8 md:grid-cols-[11rem_1fr] md:gap-10"
            >
              <p className="font-mono text-eyebrow uppercase tracking-[0.18em] text-faint md:pt-1.5">
                {item.period}
              </p>

              <div>
                <h4 className="font-display text-xl font-bold text-heading">
                  {item.role}
                </h4>
                <p className="mt-1 text-accent">{item.company}</p>
                <p className="mt-3 max-w-2xl leading-relaxed text-body">
                  {item.description}
                </p>
              </div>
            </li>
          ))}
        </ol>
      </div>

      {/* ---------- BAGIAN 3: PENDIDIKAN ---------- */}
      <div className="mt-16">
        <h3 className="font-mono text-eyebrow uppercase tracking-[0.22em] text-faint">
          Pendidikan
        </h3>

        <ol className="mt-6">
          {EDUCATION.map((item) => (
            <li
              key={`${item.school} ${item.period}`}
              className="grid gap-3 border-t border-line-soft py-6 md:grid-cols-[11rem_1fr] md:gap-10"
            >
              <p className="font-mono text-eyebrow uppercase tracking-[0.18em] text-faint md:pt-1.5">
                {item.period}
              </p>

              <div>
                <h4 className="font-display text-xl font-bold text-heading">
                  {item.school}
                </h4>
                <p className="mt-1 text-accent">{item.program}</p>
              </div>
            </li>
          ))}
        </ol>
      </div>
    </Section>
  )
}

export default Skills
