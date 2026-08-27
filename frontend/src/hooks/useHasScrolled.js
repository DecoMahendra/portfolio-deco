import { useEffect, useState } from 'react'

/*
  useHasScrolled — memberi tahu apakah halaman sudah di-scroll dari posisi paling atas.

  Dipakai navbar untuk berubah penampilan: transparan saat di puncak halaman,
  lalu berlatar gelap buram saat mulai di-scroll agar teks menu tetap terbaca.

  offset = berapa piksel harus di-scroll dulu sebelum dianggap "sudah scroll".
*/
export function useHasScrolled(offset = 12) {
  const [hasScrolled, setHasScrolled] = useState(false)

  useEffect(() => {
    const handleScroll = () => setHasScrolled(window.scrollY > offset)

    handleScroll() // cek sekali di awal, untuk kasus halaman dimuat di tengah

    // { passive: true } memberi tahu browser bahwa fungsi ini tidak akan
    // menghentikan scroll, sehingga browser boleh scroll tanpa menunggu. Lebih mulus.
    window.addEventListener('scroll', handleScroll, { passive: true })
    return () => window.removeEventListener('scroll', handleScroll)
  }, [offset])

  return hasScrolled
}
