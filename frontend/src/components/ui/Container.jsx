/*
  Container — mengatur lebar maksimal isi halaman dan jarak dari tepi layar.

  Kenapa dibuat komponen sendiri?
  Supaya navbar, hero, about, projects, dan semua section lain punya garis kiri-kanan
  yang lurus sejajar. Kalau ditulis manual di tiap section, cepat atau lambat
  ada satu yang angkanya beda dan tata letaknya jadi terlihat miring.

  className = kelas tambahan dari luar, kalau ada kebutuhan khusus.
*/
function Container({ className = '', children }) {
  return (
    <div className={`mx-auto w-full max-w-6xl px-6 md:px-10 ${className}`}>
      {children}
    </div>
  )
}

export default Container
