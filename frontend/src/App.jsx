import Navbar from './components/layout/Navbar'
import About from './components/sections/About'
import Hero from './components/sections/Hero'
import Projects from './components/sections/Projects'
import Skills from './components/sections/Skills'
import Section from './components/ui/Section'

/*
  App — merangkai seluruh halaman.

  Hero dan About sudah jadi (Phase 3). Section sisanya masih berupa
  penanda sementara dan akan diisi di phase berikutnya.

  Penanda itu sengaja tetap ada karena navbar butuh id section-nya
  untuk bisa melompat dan menandai menu yang sedang aktif.
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
        <Hero />

        <About />

        <Skills />

        <Projects />

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
