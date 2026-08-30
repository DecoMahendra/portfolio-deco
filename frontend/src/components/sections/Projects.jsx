import Section from '../ui/Section'
import { CERTIFICATES } from '../../data/certificates'
import { PROJECTS } from '../../data/projects'

/*
  Projects — berisi dua bagian: daftar karya dan daftar pelatihan/sertifikasi.

  Project sengaja dibuat berbentuk kartu, berbeda dari bagian lain di halaman
  yang memakai susunan berbaris. Alasannya: karya adalah isi terpenting di
  portfolio, jadi tampilannya perlu menonjol dan tidak larut dengan sekitarnya.

  Sertifikat kembali memakai susunan berbaris karena sifatnya pelengkap.

  Isinya diambil dari src/data/projects.js dan certificates.js.
*/
function Projects() {
  return (
    <Section
      id="projects"
      eyebrow="03 — Projects"
      title="Karya & sertifikat"
      className="border-t border-line-soft"
    >
      {/* ---------- BAGIAN 1: PROJECT ---------- */}
      {/* Satu kolom, karena project-nya baru satu. Kalau nanti sudah dua atau
          lebih, tambahkan md:grid-cols-2 di baris <ul> di bawah. */}
      <ul className="grid gap-6">
        {PROJECTS.map((project) => (
          <li
            key={project.name}
            className="rounded-card border border-line bg-surface p-7 transition-colors duration-200 hover:border-faint motion-reduce:transition-none md:p-9"
          >
            {/* Isi kartu dibagi dua kolom: penjelasan di kiri, teknologi dan
                tautan di kanan.

                Kenapa dibagi? Kartunya selebar halaman. Kalau semua isi
                ditumpuk di kiri, sisi kanan menganggur dan kartunya terlihat
                belum jadi. Kalau teksnya dibiarkan memenuhi lebar, satu baris
                jadi terlalu panjang dan mata kehilangan jejak saat pindah baris.
                Membaginya menyelesaikan keduanya sekaligus.

                Di HP kolomnya menumpuk ke bawah secara otomatis. */}
            <div className="grid gap-8 md:grid-cols-[1fr_15rem]">
              {/* --- Kolom kiri: judul & penjelasan --- */}
              <div>
                {/* h3 karena judul section-nya (h2) sudah dipakai oleh Section. */}
                <h3 className="font-display text-2xl font-bold leading-tight text-heading">
                  {project.name}
                </h3>

                <p className="mt-4 leading-relaxed text-body">
                  {project.description}
                </p>
              </div>

              {/* --- Kolom kanan: teknologi & tautan --- */}
              {/* Garis pemisah hanya muncul mulai layar sedang (md:), karena
                  di HP kedua kolom sudah menumpuk dan garis vertikal justru
                  akan tampak salah tempat.

                  Pakai border-line (#26262B), bukan border-line-soft (#1B1B20).
                  Yang kedua terlalu dekat dengan warna latar kartu — garis
                  setebal 1 piksel jadi praktis tidak terlihat. */}
              <div className="md:self-start md:border-l md:border-line md:pl-8">
                <h4 className="font-mono text-eyebrow uppercase tracking-[0.22em] text-faint">
                  Teknologi
                </h4>

                {/* Ditulis menurun satu per baris, bukan berbentuk pil yang
                    membungkus. Di kolom selebar ini, pil akan patah jadi
                    beberapa baris dengan sisi kanan bergerigi — dan bentuknya
                    berubah setiap kali nama teknologinya berganti panjang.
                    Daftar menurun selalu rapi berapa pun isinya.

                    Bingkai pil juga dilepas: di ruang sempit, empat kotak
                    berjajar terasa ramai, sementara label "Teknologi" di atas
                    sudah cukup menjelaskan ini daftar apa. */}
                <ul className="mt-4 space-y-2">
                  {project.tech.map((tech) => (
                    <li key={tech} className="font-mono text-sm text-body">
                      {tech}
                    </li>
                  ))}
                </ul>

                {/* Tautan hanya muncul kalau link-nya memang ada.
                    Tanda && berarti: kalau kiri bernilai kosong, kanan tidak dirender. */}
                {(project.repo || project.demo) && (
                  <div className="mt-7 flex flex-col gap-3 border-t border-line-soft pt-5">
                    {project.repo && (
                      <a
                        href={project.repo}
                        target="_blank"
                        /* noreferrer melindungi dari halaman tujuan yang bisa
                           mengintip atau mengubah tab asal lewat window.opener. */
                        rel="noreferrer"
                        className="group inline-flex items-center gap-2 text-sm font-semibold text-heading transition-colors hover:text-accent motion-reduce:transition-none"
                      >
                        Lihat Kode
                        <span
                          aria-hidden="true"
                          className="transition-transform duration-200 ease-out-expo group-hover:translate-x-1 motion-reduce:transition-none"
                        >
                          &rarr;
                        </span>
                      </a>
                    )}

                    {project.demo && (
                      <a
                        href={project.demo}
                        target="_blank"
                        rel="noreferrer"
                        className="group inline-flex items-center gap-2 text-sm font-semibold text-heading transition-colors hover:text-accent motion-reduce:transition-none"
                      >
                        Buka Website
                        <span
                          aria-hidden="true"
                          className="transition-transform duration-200 ease-out-expo group-hover:translate-x-1 motion-reduce:transition-none"
                        >
                          &rarr;
                        </span>
                      </a>
                    )}
                  </div>
                )}
              </div>
            </div>
          </li>
        ))}
      </ul>

      {/* ---------- BAGIAN 2: PELATIHAN & SERTIFIKASI ---------- */}
      {/* Lebar kolom kirinya (11rem) sama dengan bagian Keahlian, Pengalaman,
          dan Pendidikan, supaya seluruh halaman punya satu garis yang lurus. */}
      <div className="mt-20">
        <h3 className="font-mono text-eyebrow uppercase tracking-[0.22em] text-faint">
          Pelatihan &amp; Sertifikasi
        </h3>

        <ul className="mt-6">
          {CERTIFICATES.map((item) => (
            <li
              key={`${item.name} ${item.year}`}
              className="grid gap-2 border-t border-line-soft py-6 md:grid-cols-[11rem_1fr] md:gap-10"
            >
              <p className="font-mono text-eyebrow uppercase tracking-[0.18em] text-faint md:pt-1">
                {item.year}
              </p>

              <div>
                <h4 className="font-display text-lg font-bold text-heading">
                  {item.name}
                </h4>
                <p className="mt-1 text-body">{item.organizer}</p>
              </div>
            </li>
          ))}
        </ul>
      </div>
    </Section>
  )
}

export default Projects
