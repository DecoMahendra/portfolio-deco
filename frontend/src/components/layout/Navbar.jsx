import { useState } from 'react'
import Container from '../ui/Container'
import MenuToggle from './MenuToggle'
import MobileMenu from './MobileMenu'
import { NAV_ITEMS, SECTION_IDS } from '../../data/navigation'
import { useActiveSection } from '../../hooks/useActiveSection'
import { useHasScrolled } from '../../hooks/useHasScrolled'

/*
  Navbar — menu utama yang menempel di bagian atas layar.

  Tiga perilaku utamanya:
  1. Menempel di atas (fixed) supaya menu selalu bisa dijangkau tanpa scroll ke puncak.
  2. Transparan saat di puncak halaman, lalu berubah gelap-buram saat di-scroll,
     supaya tulisan menu tetap terbaca di atas konten apa pun.
  3. Menu yang sesuai posisi scroll akan menyala (lihat hook useActiveSection).
*/
function Navbar() {
  const [isMenuOpen, setIsMenuOpen] = useState(false)
  const hasScrolled = useHasScrolled()
  const activeId = useActiveSection(SECTION_IDS)

  const closeMenu = () => setIsMenuOpen(false)
  const toggleMenu = () => setIsMenuOpen((open) => !open)

  return (
    <header className="fixed inset-x-0 top-0 z-50">
      {/* Lapisan latar navbar. Dipisah dari <nav> supaya efek buram
          bisa memenuhi lebar layar, sementara isinya tetap sejajar Container. */}
      <div
        className={`transition-all duration-300 ease-out-expo motion-reduce:transition-none ${
          hasScrolled || isMenuOpen
            ? 'border-b border-line bg-page/80 backdrop-blur-xl'
            : 'border-b border-transparent bg-transparent'
        }`}
      >
        <Container>
          <nav
            aria-label="Navigasi utama"
            className="flex h-16 items-center justify-between md:h-20"
          >
            {/* --- Logo / nama --- */}
            <a
              href="#home"
              onClick={closeMenu}
              className="group font-display text-lg font-bold tracking-tight text-heading"
            >
              deco
              {/* Titik lime yang membesar saat kursor lewat. Detail kecil,
                  tapi membuat logo terasa "hidup" dan sengaja dirancang. */}
              <span className="ml-0.5 inline-block text-accent transition-transform duration-300 ease-out-expo group-hover:scale-150 motion-reduce:transition-none">
                .
              </span>
            </a>

            {/* --- Menu desktop (disembunyikan di HP) --- */}
            <ul className="hidden items-center gap-1 md:flex">
              {NAV_ITEMS.map((item) => {
                const isActive = activeId === item.id

                return (
                  <li key={item.id}>
                    <a
                      href={`#${item.id}`}
                      /* aria-current memberi tahu pembaca layar menu mana yang
                         sedang aktif. Warna saja tidak cukup: pengguna tunanetra
                         dan pengguna buta warna tidak bisa melihatnya. */
                      aria-current={isActive ? 'true' : undefined}
                      className={`relative rounded-full px-4 py-2 text-sm font-medium transition-colors duration-200 motion-reduce:transition-none ${
                        isActive
                          ? 'text-accent'
                          : 'text-body hover:bg-white/5 hover:text-heading'
                      }`}
                    >
                      {item.label}

                      {/* Garis tipis penanda menu aktif */}
                      {isActive && (
                        <span
                          aria-hidden="true"
                          className="absolute inset-x-4 -bottom-px h-px bg-accent"
                        />
                      )}
                    </a>
                  </li>
                )
              })}
            </ul>

            {/* --- Tombol ajakan (desktop) --- */}
            <a
              href="#contact"
              className="group hidden items-center gap-2 rounded-full border border-line bg-raised px-5 py-2.5 text-sm font-semibold text-heading transition-colors duration-200 hover:border-accent hover:bg-accent hover:text-page motion-reduce:transition-none md:inline-flex"
            >
              Hubungi Saya
              {/* Titik kecil berkedip: penanda "tersedia untuk dihubungi". */}
              <span
                aria-hidden="true"
                className="h-1.5 w-1.5 rounded-full bg-accent transition-colors group-hover:bg-page"
              />
            </a>

            {/* --- Tombol hamburger (HP) --- */}
            <MenuToggle isOpen={isMenuOpen} onToggle={toggleMenu} />
          </nav>
        </Container>
      </div>

      <MobileMenu isOpen={isMenuOpen} onClose={closeMenu} activeId={activeId} />
    </header>
  )
}

export default Navbar
