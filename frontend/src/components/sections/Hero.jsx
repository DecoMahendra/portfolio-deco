import Container from '../ui/Container'
import { PROFILE } from '../../data/profile'

/*
  Hero — bagian paling atas halaman, yang pertama dilihat pengunjung.

  Isinya sengaja sedikit: label status, nama besar, satu kalimat, dua tombol.
  Alasannya, pengunjung memutuskan mau lanjut membaca atau tidak dalam beberapa
  detik pertama. Terlalu banyak tulisan di sini justru membuat mereka pergi.

  Semua teksnya diambil dari src/data/profile.js.
*/
function Hero() {
  return (
    <section
      id="home"
      aria-labelledby="home-heading"
      className="flex min-h-svh items-center pt-28 pb-20 md:pt-32"
    >
      <Container>
        {/* Label status dengan titik hijau berkedip.
            Titiknya dibuat dari dua lingkaran bertumpuk: satu diam,
            satu membesar-memudar (animate-ping) supaya terlihat "hidup". */}
        <p className="mb-8 inline-flex items-center gap-2.5 rounded-full border border-line bg-surface px-4 py-2 font-mono text-eyebrow uppercase tracking-[0.18em] text-body">
          <span aria-hidden="true" className="relative flex h-2 w-2">
            <span className="absolute inline-flex h-full w-full animate-ping rounded-full bg-accent opacity-60" />
            <span className="relative inline-flex h-2 w-2 rounded-full bg-accent" />
          </span>
          {PROFILE.availability}
        </p>

        <h1
          id="home-heading"
          className="max-w-5xl font-display text-display font-bold leading-[0.92] tracking-tight text-heading"
        >
          {PROFILE.name}
          <span className="text-accent">.</span>
          <br />
          <span className="text-faint">{PROFILE.role}</span>
        </h1>

        <p className="mt-8 max-w-xl text-lg leading-relaxed text-body">
          {PROFILE.tagline}
        </p>

        {/* Dua tombol. Di HP disusun ke bawah (flex-col) supaya lebar penuh
            dan mudah disentuh; mulai layar kecil ke atas berjajar (sm:flex-row). */}
        <div className="mt-10 flex flex-col gap-3 sm:flex-row sm:items-center">
          <a
            href="#projects"
            className="group inline-flex items-center justify-center gap-2 rounded-full bg-accent px-7 py-3.5 font-display font-bold text-page transition-colors duration-200 hover:bg-accent-deep motion-reduce:transition-none"
          >
            Lihat Project
            {/* Panah bergeser sedikit saat kursor lewat. Detail kecil yang
                membuat tombol terasa merespons, bukan sekadar berubah warna. */}
            <span
              aria-hidden="true"
              className="transition-transform duration-200 ease-out-expo group-hover:translate-x-1 motion-reduce:transition-none"
            >
              &rarr;
            </span>
          </a>

          <a
            href="#contact"
            className="inline-flex items-center justify-center rounded-full border border-line bg-raised px-7 py-3.5 font-display font-bold text-heading transition-colors duration-200 hover:border-faint hover:bg-surface motion-reduce:transition-none"
          >
            Hubungi Saya
          </a>
        </div>
      </Container>
    </section>
  )
}

export default Hero
