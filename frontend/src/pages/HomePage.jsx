import About from '../components/sections/About'
import Contact from '../components/sections/Contact'
import Hero from '../components/sections/Hero'
import Projects from '../components/sections/Projects'
import Skills from '../components/sections/Skills'

/*
  HomePage — halaman beranda (alamat "/").

  Isinya sama seperti website satu halaman sebelumnya. Dipindah dari App.jsx
  karena sekarang App hanya mengatur alamat mana menampilkan halaman apa.

  Judul tab untuk beranda ada di index.html, jadi tidak ditulis di sini.
*/
function HomePage() {
  return (
    <>
      <Hero />
      <About />
      <Skills />
      <Projects />
      <Contact />
    </>
  )
}

export default HomePage
