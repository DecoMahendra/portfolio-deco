import About from '../components/sections/About'
import Certificates from '../components/sections/Certificates'
import Contact from '../components/sections/Contact'
import Hero from '../components/sections/Hero'
import Projects from '../components/sections/Projects'
import Skills from '../components/sections/Skills'
import { SITE_URL } from '../data/site'

/*
  HomePage — halaman beranda (alamat "/").

  Isinya sama seperti website satu halaman sebelumnya. Dipindah dari App.jsx
  karena sekarang App hanya mengatur alamat mana menampilkan halaman apa.

  Judul tab untuk beranda ada di index.html, jadi tidak ditulis di sini.
*/
function HomePage() {
  return (
    <>
      {/* Judul tab dan deskripsi beranda ditulis di index.html. */}
      <link rel="canonical" href={SITE_URL} />

      <Hero />
      <About />
      <Skills />
      <Projects />
      <Certificates />
      <Contact />
    </>
  )
}

export default HomePage
