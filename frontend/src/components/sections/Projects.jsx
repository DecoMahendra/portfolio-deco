import { Link } from 'react-router'
import ProjectMarquee from '../ui/ProjectMarquee'
import Section from '../ui/Section'
import { CERTIFICATES } from '../../data/certificates'
import { PROJECTS } from '../../data/projects'

/*
  Projects — berisi dua bagian: daftar karya dan daftar pelatihan/sertifikasi.

  Project tampil sebagai ban berjalan berisi kartu bergambar, berbeda dari
  bagian lain di halaman yang memakai susunan berbaris. Alasannya: karya adalah
  isi terpenting di portfolio, jadi tampilannya perlu menonjol. Tiap kartu
  menuju halaman detail project-nya; semua project ada di /projects.

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
      {/* Ban berjalan berisi kartu ringkas. Penjelasan lengkap, galeri gambar,
          dan tombol GitHub/Demo ada di halaman detail tiap project. */}
      <ProjectMarquee projects={PROJECTS} />

      <Link
        to="/projects"
        className="group mt-8 inline-flex items-center gap-2 font-semibold text-heading transition-colors hover:text-accent motion-reduce:transition-none"
      >
        Lihat semua project
        <span
          aria-hidden="true"
          className="transition-transform duration-200 ease-out-expo group-hover:translate-x-1 motion-reduce:transition-none"
        >
          &rarr;
        </span>
      </Link>

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
              key={item.id}
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
