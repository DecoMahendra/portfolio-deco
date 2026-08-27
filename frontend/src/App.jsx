import Navbar from './components/layout/Navbar'
import Container from './components/ui/Container'
import Section from './components/ui/Section'

/*
  App — merangkai seluruh halaman.

  Di Phase 2 ini, isi tiap section masih berupa penanda sementara.
  Yang sudah benar-benar jadi: design system (warna & font), navbar,
  dan kerangka section beserta id-nya.

  Section-section di bawah sengaja dibuat sekarang walau isinya belum ada,
  karena navbar butuh id section itu untuk bisa melompat dan menandai menu aktif.
*/
function App() {
  return (
    <>
      {/* Link "lompat ke konten" untuk pengguna keyboard.
          Tidak terlihat sampai ditekan Tab. Fungsinya: melewati navbar
          langsung ke isi halaman, tanpa harus menekan Tab satu per satu. */}
      <a
        href="#home"
        className="sr-only focus:not-sr-only focus:fixed focus:left-6 focus:top-6 focus:z-[60] focus:rounded-full focus:bg-accent focus:px-5 focus:py-3 focus:font-semibold focus:text-page"
      >
        Lompat ke konten
      </a>

      <Navbar />

      {/* Cahaya lime samar di belakang bagian atas halaman.
          aria-hidden karena murni hiasan, tidak perlu dibacakan pembaca layar.
          pointer-events-none supaya tidak menghalangi klik. */}
      <div
        aria-hidden="true"
        className="pointer-events-none fixed inset-0 -z-10 bg-[radial-gradient(60rem_40rem_at_50%_-15%,rgba(212,255,63,0.08),transparent_70%)]"
      />

      <main>
        {/* ---------- HERO (isi sebenarnya dibuat di Phase 3) ---------- */}
        <section
          id="home"
          aria-labelledby="home-heading"
          className="flex min-h-svh items-center pt-24 pb-20"
        >
          <Container>
            <p className="mb-6 font-mono text-eyebrow uppercase tracking-[0.22em] text-accent">
              Phase 2 — Design System &amp; Navbar
            </p>

            <h1
              id="home-heading"
              className="max-w-4xl font-display text-display font-bold leading-[0.95] tracking-tight text-heading"
            >
              Deco Mahendra,
              <br />
              <span className="text-faint">Full Stack Developer.</span>
            </h1>

            <p className="mt-8 max-w-xl text-lg leading-relaxed text-body">
              Kerangka halaman dan sistem desain sudah terpasang. Coba scroll ke
              bawah dan perhatikan menu di atas ikut menyala mengikuti bagian
              yang sedang kamu lihat.
            </p>
          </Container>
        </section>

        {/* ---------- SECTION SEMENTARA ---------- */}
        <Section
          id="about"
          eyebrow="01 — About"
          title="Tentang saya"
          description="Bagian ini akan diisi di Phase 3: foto, cerita singkat, dan latar belakang."
          className="border-t border-line-soft"
        />

        <Section
          id="skills"
          eyebrow="02 — Skills"
          title="Keahlian & pengalaman"
          description="Bagian ini akan diisi di Phase 4: daftar teknologi yang dikuasai dan riwayat pengalaman."
          className="border-t border-line-soft"
        />

        <Section
          id="projects"
          eyebrow="03 — Projects"
          title="Karya & sertifikat"
          description="Bagian ini akan diisi di Phase 5: project yang pernah dikerjakan beserta sertifikat."
          className="border-t border-line-soft"
        />

        <Section
          id="services"
          eyebrow="04 — Services"
          title="Layanan"
          description="Bagian ini akan diisi di Phase 6: jenis pekerjaan yang bisa saya kerjakan."
          className="border-t border-line-soft"
        />

        <Section
          id="contact"
          eyebrow="05 — Contact"
          title="Mari bekerja sama"
          description="Bagian ini akan diisi di Phase 6: form kontak dan tautan media sosial."
          className="border-t border-line-soft"
        />
      </main>
    </>
  )
}

export default App
