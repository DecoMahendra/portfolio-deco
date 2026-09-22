import { useEffect } from 'react'
import { useLocation } from 'react-router'

/*
  useScrollOnNavigate — mengatur posisi gulir setiap kali pindah alamat.

  Kenapa perlu? Di website banyak halaman, React Router mengganti isi halaman
  tanpa memuat ulang browser. Akibatnya browser tidak mengurus gulirnya:
  - buka halaman baru       -> posisi gulir tertinggal di tengah halaman lama
  - klik "/#about" dari halaman lain -> browser tidak tahu harus menggulir ke About

  Jadi hook ini yang mengurusnya:
  - alamat punya #section  -> gulir ke section itu (halus, ikut scroll-behavior di CSS)
  - alamat tanpa #          -> langsung ke paling atas (instant: halaman baru
                               harus muncul dari atas, bukan meluncur dari tengah)

  key berubah di setiap perpindahan, termasuk saat mengklik alamat yang sama
  lagi — misalnya logo di beranda — jadi gulir ke atas tetap terjadi.
*/
export function useScrollOnNavigate() {
  const { hash, key } = useLocation()

  useEffect(() => {
    const target = hash && document.getElementById(hash.slice(1))

    if (target) {
      target.scrollIntoView()
    } else {
      window.scrollTo({ top: 0, behavior: 'instant' })
    }
  }, [hash, key])
}
