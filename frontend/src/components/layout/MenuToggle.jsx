/*
  MenuToggle — tombol hamburger untuk membuka/menutup menu di layar HP.

  Ikonnya bukan gambar, melainkan dua garis tipis yang dibuat dari <span>.
  Saat menu terbuka, kedua garis berputar dan bertemu membentuk tanda X.
  Cara ini tidak butuh library ikon tambahan, dan animasinya jadi mulus
  karena hanya menganimasikan transform (gerakan yang paling ringan bagi browser).

  Props:
  - isOpen   : status menu, true kalau sedang terbuka
  - onToggle : fungsi yang dipanggil saat tombol diklik
*/
function MenuToggle({ isOpen, onToggle }) {
  // Kelas yang sama untuk kedua garis, supaya tidak ditulis dua kali.
  const barClass =
    'block h-px w-6 bg-current transition-transform duration-300 ease-out-expo motion-reduce:transition-none'

  return (
    <button
      type="button"
      onClick={onToggle}
      /* aria-expanded memberi tahu pembaca layar apakah menu sedang terbuka.
         aria-controls menunjuk ke id panel menu yang dikendalikan tombol ini. */
      aria-expanded={isOpen}
      aria-controls="mobile-menu"
      aria-label={isOpen ? 'Tutup menu' : 'Buka menu'}
      className="flex h-11 w-11 flex-col items-center justify-center gap-[7px] rounded-lg text-heading transition-colors hover:bg-white/5 md:hidden"
    >
      <span
        className={`${barClass} ${isOpen ? 'translate-y-[4px] rotate-45' : ''}`}
      />
      <span
        className={`${barClass} ${isOpen ? '-translate-y-[4px] -rotate-45' : ''}`}
      />
    </button>
  )
}

export default MenuToggle
