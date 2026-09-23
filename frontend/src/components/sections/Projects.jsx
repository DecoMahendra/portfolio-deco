import { Link } from 'react-router'
import ProjectMarquee from '../ui/ProjectMarquee'
import Section from '../ui/Section'
import { PROJECTS } from '../../data/projects'

/*
  Projects — daftar karya.

  Tampil sebagai ban berjalan berisi kartu bergambar, berbeda dari bagian lain
  di halaman yang memakai susunan berbaris. Alasannya: karya adalah isi
  terpenting di portfolio, jadi tampilannya perlu menonjol.

  Tiap kartu menuju halaman detail project-nya; semuanya ada di /projects.
  Isinya diambil dari src/data/projects.js.
*/
function Projects() {
  return (
    <Section
      id="projects"
      eyebrow="03 — Projects"
      title="Karya yang sudah dibangun"
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

    </Section>
  )
}

export default Projects
