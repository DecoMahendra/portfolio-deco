import { Outlet } from 'react-router'
import Footer from './Footer'
import Navbar from './Navbar'
import { useScrollOnNavigate } from '../../hooks/useScrollOnNavigate'

/*
  Layout — kerangka yang sama untuk semua halaman.

  Navbar, cahaya latar, dan Footer ditulis sekali di sini. Isi halaman yang
  berbeda-beda (beranda, halaman project, 404) masuk lewat <Outlet />:
  React Router menaruh halaman yang cocok dengan alamat di titik itu.
*/
function Layout() {
  useScrollOnNavigate()

  return (
    <>
      {/* Link "lompat ke konten" untuk pengguna keyboard.
          Tidak terlihat sampai ditekan Tab. Fungsinya: melewati navbar
          langsung ke isi halaman, tanpa harus menekan Tab satu per satu.
          Menuju <main>, bukan section tertentu, supaya berfungsi di semua halaman. */}
      <a
        href="#main-content"
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

      {/* tabIndex -1: supaya <main> bisa menerima fokus dari link "lompat ke konten",
          tanpa ikut masuk urutan Tab biasa. */}
      <main id="main-content" tabIndex={-1} className="focus:outline-none">
        <Outlet />
      </main>

      <Footer />
    </>
  )
}

export default Layout
