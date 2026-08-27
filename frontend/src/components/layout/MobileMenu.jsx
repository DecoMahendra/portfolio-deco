import { useEffect } from 'react'
import { NAV_ITEMS } from '../../data/navigation'
import { useLockBodyScroll } from '../../hooks/useLockBodyScroll'

/*
  MobileMenu — panel menu layar penuh untuk HP.

  Panel ini SELALU ada di dalam halaman, hanya disembunyikan saat tertutup.
  Kenapa tidak dihapus saja saat tertutup? Karena elemen yang baru muncul
  tidak bisa dianimasikan dengan mulus. Dengan cara ini, menu bisa memudar
  masuk dan keluar.

  Props:
  - isOpen   : status menu
  - onClose  : fungsi untuk menutup menu
  - activeId : id section yang sedang dilihat, untuk menandai menu aktif
*/
function MobileMenu({ isOpen, onClose, activeId }) {
  useLockBodyScroll(isOpen)

  // Menutup menu saat tombol Escape ditekan. Ini perilaku standar yang
  // diharapkan pengguna keyboard dari semua panel/dialog.
  useEffect(() => {
    if (!isOpen) return

    const handleKeyDown = (event) => {
      if (event.key === 'Escape') onClose()
    }

    window.addEventListener('keydown', handleKeyDown)
    return () => window.removeEventListener('keydown', handleKeyDown)
  }, [isOpen, onClose])

  return (
    <div
      id="mobile-menu"
      /* aria-hidden + inert menyembunyikan panel dari pembaca layar DAN dari
         tombol Tab saat menu tertutup. Tanpa ini, pengguna keyboard akan
         terjebak menekan Tab pada link yang tidak terlihat di layar. */
      aria-hidden={!isOpen}
      inert={!isOpen}
      className={`fixed inset-x-0 top-16 bottom-0 z-40 border-t border-line bg-page/95 backdrop-blur-xl transition-all duration-300 ease-out-expo motion-reduce:transition-none md:hidden ${
        isOpen
          ? 'visible translate-y-0 opacity-100'
          : 'invisible -translate-y-3 opacity-0'
      }`}
    >
      <nav aria-label="Navigasi mobile" className="px-6 py-10">
        <ul className="flex flex-col">
          {NAV_ITEMS.map((item, index) => {
            const isActive = activeId === item.id

            return (
              <li key={item.id} className="border-b border-line-soft">
                <a
                  href={`#${item.id}`}
                  onClick={onClose}
                  aria-current={isActive ? 'true' : undefined}
                  /* transitionDelay membuat link muncul satu per satu (berurutan)
                     saat menu dibuka, bukan serentak. Terasa lebih hidup. */
                  style={{ transitionDelay: isOpen ? `${index * 50 + 80}ms` : '0ms' }}
                  className={`flex items-baseline gap-4 py-5 font-display text-3xl font-medium tracking-tight transition-all duration-500 ease-out-expo motion-reduce:transition-none ${
                    isOpen ? 'translate-y-0 opacity-100' : 'translate-y-3 opacity-0'
                  } ${isActive ? 'text-accent' : 'text-heading'}`}
                >
                  <span className="font-mono text-eyebrow text-faint">
                    {String(index + 1).padStart(2, '0')}
                  </span>
                  {item.label}
                </a>
              </li>
            )
          })}
        </ul>

        <a
          href="#contact"
          onClick={onClose}
          className="mt-10 flex items-center justify-center rounded-full bg-accent px-6 py-4 font-display text-base font-bold text-page transition-colors hover:bg-accent-deep"
        >
          Hubungi Saya
        </a>
      </nav>
    </div>
  )
}

export default MobileMenu
