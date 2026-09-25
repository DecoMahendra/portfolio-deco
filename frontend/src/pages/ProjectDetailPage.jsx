import { useParams } from 'react-router'
import BackLink from '../components/ui/BackLink'
import Container from '../components/ui/Container'
import ImageCarousel from '../components/ui/ImageCarousel'
import NotFoundPage from './NotFoundPage'
import { PROJECTS } from '../data/projects'
import { SITE_URL } from '../data/site'

/*
  ProjectDetailPage — satu project (alamat "/projects/nama-project").

  useParams membaca bagian alamat yang berubah-ubah. Route-nya ditulis
  "/projects/:slug", jadi untuk alamat "/projects/website-portfolio-pribadi",
  useParams memberi { slug: 'website-portfolio-pribadi' }.

  Alamat yang project-nya tidak ada akan menampilkan halaman 404 yang sama
  dengan alamat ngawur lainnya — pengunjung tidak dibiarkan melihat halaman kosong.
*/
function ProjectDetailPage() {
  const { slug } = useParams()
  const project = PROJECTS.find((item) => item.slug === slug)

  if (!project) return <NotFoundPage />

  // Deskripsi panjang boleh ditulis beberapa paragraf, dipisah baris kosong.
  const paragraphs = project.description.split(/\r?\n\s*\r?\n/).filter(Boolean)

  return (
    <>
      <title>{`${project.name} — Deco Mahendra`}</title>
      <meta name="description" content={project.description.slice(0, 155)} />
      <link rel="canonical" href={`${SITE_URL}/projects/${project.slug}`} />

      <Container>
        <div className="pt-32 pb-24 md:pt-40 md:pb-32">
          <BackLink fallbackTo="/projects" fallbackLabel="Semua project" />

          <h1 className="mt-6 max-w-3xl font-display text-title font-bold leading-[1.05] tracking-tight text-heading">
            {project.name}
          </h1>

          {/* Daftar teknologi, ditulis mendatar dan membungkus kalau kepanjangan. */}
          <ul className="mt-6 flex flex-wrap gap-x-3 gap-y-2">
            {project.tech.map((tech) => (
              <li
                key={tech}
                className="rounded-full border border-line px-3 py-1 font-mono text-xs text-body"
              >
                {tech}
              </li>
            ))}
          </ul>

          {project.images.length > 0 && (
            <div className="mt-12">
              <ImageCarousel images={project.images} label={project.name} />
            </div>
          )}

          <div className="mt-14 grid gap-12 md:grid-cols-[1fr_16rem]">
            <div className="max-w-2xl space-y-5">
              {paragraphs.map((paragraph) => (
                <p key={paragraph} className="text-lg leading-relaxed text-body">
                  {paragraph}
                </p>
              ))}
            </div>

            {/* Tautan hanya muncul kalau memang diisi di dashboard admin. */}
            {(project.repo || project.demo) && (
              <div className="flex flex-col gap-3 md:self-start">
                {project.demo && (
                  <a
                    href={project.demo}
                    target="_blank"
                    /* noreferrer melindungi dari halaman tujuan yang bisa
                       mengintip atau mengubah tab asal lewat window.opener. */
                    rel="noreferrer"
                    className="inline-flex items-center justify-center gap-2 rounded-full bg-accent px-6 py-3 font-display font-bold text-page transition-colors duration-200 hover:bg-accent-deep motion-reduce:transition-none"
                  >
                    Buka Website
                  </a>
                )}

                {project.repo && (
                  <a
                    href={project.repo}
                    target="_blank"
                    rel="noreferrer"
                    className="inline-flex items-center justify-center gap-2 rounded-full border border-line bg-raised px-6 py-3 font-display font-bold text-heading transition-colors duration-200 hover:border-accent hover:text-accent motion-reduce:transition-none"
                  >
                    Lihat Kode
                  </a>
                )}
              </div>
            )}
          </div>
        </div>
      </Container>
    </>
  )
}

export default ProjectDetailPage
