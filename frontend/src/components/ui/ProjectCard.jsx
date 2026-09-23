import { Link } from 'react-router'
import { cloudinaryImage } from '../../data/cloudinary'

/*
  ProjectCard — kartu satu project: gambar sampul, nama, penjelasan singkat,
  dan teknologi. Seluruh kartu adalah satu tautan ke halaman detail project.

  Dipakai di dua tempat: ban berjalan di beranda dan daftar di /projects.

  headingLevel: tingkat judul kartu. Di beranda 3 (di bawah judul section h2),
  di halaman /projects 2 (di bawah judul halaman h1) — supaya urutan judul
  tidak melompat, sesuai aturan aksesibilitas.

  isFocusable: false untuk kartu salinan di ban berjalan. Kartunya tetap bisa
  diklik, tapi dilewati tombol Tab supaya tidak berhenti dua kali di kartu
  yang sama.
*/
function ProjectCard({ project, headingLevel = 3, isFocusable = true }) {
  const Heading = `h${headingLevel}`
  const cover = project.images[0]

  return (
    <Link
      to={`/projects/${project.slug}`}
      tabIndex={isFocusable ? undefined : -1}
      className="group flex h-full flex-col overflow-hidden rounded-card border border-line bg-surface transition-colors duration-200 hover:border-accent focus-visible:border-accent motion-reduce:transition-none"
    >
      {/* aspect-[2/1] memesan tempat gambar sebelum dimuat, supaya halaman
          tidak melompat saat gambarnya muncul. Perbandingan 2:1 dipilih karena
          cocok untuk tangkapan layar website, yang bentuknya memanjang. */}
      <div className="aspect-[2/1] overflow-hidden border-b border-line bg-raised">
        {cover ? (
          /* alt kosong: nama project di bawahnya sudah menjelaskan kartu ini.
             Kalau diisi juga, pembaca layar menyebut nama yang sama dua kali. */
          <img
            src={cloudinaryImage(cover.url, 640, 320)}
            alt=""
            width="640"
            height="320"
            loading="lazy"
            className="h-full w-full object-cover transition-transform duration-500 ease-out-expo group-hover:scale-105 motion-reduce:transition-none"
          />
        ) : (
          // Project tanpa gambar: huruf pertama namanya sebagai pengganti sampul.
          <div
            aria-hidden="true"
            className="flex h-full items-center justify-center font-display text-6xl font-bold text-line"
          >
            {project.name.charAt(0)}
          </div>
        )}
      </div>

      <div className="flex flex-1 flex-col p-6">
        <Heading className="font-display text-xl font-bold leading-tight text-heading transition-colors group-hover:text-accent motion-reduce:transition-none">
          {project.name}
        </Heading>

        {/* line-clamp-2: penjelasan panjang dipotong jadi dua baris dengan "…",
            supaya semua kartu sama tinggi. Penjelasan lengkapnya di halaman detail. */}
        <p className="mt-3 line-clamp-2 text-sm leading-relaxed text-body">
          {project.description}
        </p>

        {/* mt-auto mendorong baris teknologi ke dasar kartu, sejajar antar kartu. */}
        <p className="mt-auto pt-5 font-mono text-xs text-faint">
          {project.tech.slice(0, 3).join(' · ')}
          {project.tech.length > 3 && ` +${project.tech.length - 3}`}
        </p>
      </div>
    </Link>
  )
}

export default ProjectCard
