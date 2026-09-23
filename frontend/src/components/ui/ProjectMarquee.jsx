import Marquee from './Marquee'
import ProjectCard from './ProjectCard'

/*
  ProjectMarquee — deretan kartu project di beranda.

  Gerakan, jeda, dan putarannya diurus komponen Marquee. Di sini hanya
  ditentukan kartu apa yang ditampilkan dan berapa jumlah minimalnya.
*/

/*
  Satu salinan harus lebih lebar dari area tampilnya, supaya saat putaran
  berulang tidak muncul ruang kosong. Area tampil maksimal ±67rem, satu kartu
  beserta jaraknya ±21,5rem -> minimal 4 kartu. Kalau project belum sebanyak
  itu, sisanya diisi kartu "Coming soon".
*/
const MIN_CARDS = 4

function ProjectMarquee({ projects }) {
  const fillerCount = Math.max(0, MIN_CARDS - projects.length)

  return (
    <Marquee ariaLabel="Daftar project, bergeser otomatis">
      {(isCopy) => (
        <>
          {projects.map((project) => (
            <li key={project.id} className="w-72 shrink-0 md:w-80">
              <ProjectCard project={project} isFocusable={!isCopy} />
            </li>
          ))}

          {/* Kartu pengisi identik dan urutannya tidak pernah berubah, jadi nomor
              urut aman dipakai sebagai key. aria-hidden karena hanya pengisi ruang. */}
          {Array.from({ length: fillerCount }, (_, index) => (
            <li key={`coming-soon-${index}`} aria-hidden="true" className="w-72 shrink-0 md:w-80">
              <div className="flex h-full min-h-80 flex-col items-center justify-center gap-3 rounded-card border border-dashed border-line p-6 text-center">
                <span className="font-mono text-eyebrow uppercase tracking-[0.22em] text-accent">
                  Coming soon
                </span>
                <span className="text-sm text-faint">Project berikutnya sedang dikerjakan.</span>
              </div>
            </li>
          ))}
        </>
      )}
    </Marquee>
  )
}

export default ProjectMarquee
