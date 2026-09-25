import BackLink from '../components/ui/BackLink'
import Container from '../components/ui/Container'
import ProjectCard from '../components/ui/ProjectCard'
import { PROJECTS } from '../data/projects'
import { SITE_URL } from '../data/site'

/*
  ProjectsPage — daftar semua project (alamat "/projects").

  Beranda hanya menampilkan sebagian dalam bentuk deretan bergerak; halaman ini
  menampilkan semuanya sekaligus supaya mudah ditelusuri.

  Kartunya sama persis dengan yang di beranda, hanya tingkat judulnya 2 karena
  di sini judul halaman (h1) ada di atasnya.
*/
function ProjectsPage() {
  return (
    <>
      <title>Project — Deco Mahendra</title>
      <link rel="canonical" href={`${SITE_URL}/projects`} />
      <meta
        name="description"
        content="Kumpulan project yang dikerjakan Deco Mahendra: aplikasi web, teknologi yang dipakai, dan tautan ke kode maupun demo."
      />

      <Container>
        <div className="pt-32 pb-24 md:pt-40 md:pb-32">
          <BackLink fallbackTo="/" fallbackLabel="Beranda" />

          <p className="mt-6 font-mono text-eyebrow uppercase tracking-[0.22em] text-accent">
            Project
          </p>

          <h1 className="mt-5 max-w-3xl font-display text-title font-bold leading-[1.05] tracking-tight text-heading">
            Yang sudah saya bangun
          </h1>

          <p className="mt-6 max-w-xl text-lg leading-relaxed text-body">
            Setiap project punya halaman sendiri berisi tampilan, teknologi yang
            dipakai, dan tautan ke kodenya.
          </p>

          {PROJECTS.length > 0 ? (
            <ul className="mt-16 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
              {PROJECTS.map((project) => (
                <li key={project.id}>
                  <ProjectCard project={project} headingLevel={2} />
                </li>
              ))}
            </ul>
          ) : (
            <p className="mt-16 rounded-card border border-dashed border-line px-6 py-16 text-center text-faint">
              Belum ada project yang ditampilkan.
            </p>
          )}
        </div>
      </Container>
    </>
  )
}

export default ProjectsPage
