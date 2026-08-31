import Footer from './components/layout/Footer'
import Navbar from './components/layout/Navbar'
import About from './components/sections/About'
import Contact from './components/sections/Contact'
import Hero from './components/sections/Hero'
import Projects from './components/sections/Projects'
import Skills from './components/sections/Skills'

/*
  App — merangkai seluruh halaman.

  Seluruh section sudah terisi: Hero, About, Skills, Projects, Contact.
  Section Services dihapus karena belum ada isi yang benar-benar perlu
  ditampilkan — lebih baik tidak ada daripada terasa dipaksakan.
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

        <Contact />
      </main>

      <Footer />
    </>
  )
}

export default App
