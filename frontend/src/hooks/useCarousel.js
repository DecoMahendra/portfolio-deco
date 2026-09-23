import { useCallback, useEffect, useState } from 'react'

/*
  useCarousel — mengurus slide gambar: pindah ke gambar tertentu, tahu gambar
  mana yang sedang tampil, dan berpindah sendiri setiap beberapa detik.

  Cara berpindahnya memakai posisi gulir (scrollLeft), sama seperti deretan
  project di beranda. Dengan begitu geseran jari, tombol panah, dan perpindahan
  otomatis memakai "kemudi" yang sama — tidak saling bertabrakan.

  Gambar yang sedang tampil tidak disimpan saat tombol ditekan, melainkan
  dibaca dari posisi gulir. Jadi kalau pengunjung menggeser sendiri dengan jari,
  titik penandanya tetap ikut berpindah.
*/
export function useCarousel(ref, { count, isPaused = false, intervalMs = 5000 }) {
  const [index, setIndex] = useState(0)

  const prefersReducedMotion = () =>
    window.matchMedia('(prefers-reduced-motion: reduce)').matches

  const goTo = useCallback(
    (target) => {
      const element = ref.current
      if (!element) return

      element.scrollTo({
        left: target * element.clientWidth,
        // Pengunjung yang mematikan animasi: berpindah langsung, tanpa meluncur.
        behavior: prefersReducedMotion() ? 'auto' : 'smooth',
      })
    },
    [ref],
  )

  // Membaca gambar keberapa yang sedang tampil dari posisi gulirnya.
  useEffect(() => {
    const element = ref.current
    if (!element) return

    const readIndex = () => {
      if (element.clientWidth === 0) return
      setIndex(Math.round(element.scrollLeft / element.clientWidth))
    }

    element.addEventListener('scroll', readIndex)
    return () => element.removeEventListener('scroll', readIndex)
  }, [ref])

  // Berpindah sendiri.
  useEffect(() => {
    const element = ref.current
    if (!element || isPaused || count < 2) return
    if (prefersReducedMotion()) return

    const timer = setInterval(() => {
      /*
        Posisi sekarang dibaca ulang saat waktunya tiba, bukan diambil dari
        nilai index saat timer dibuat. Kalau diambil dari situ, nilainya sudah
        basi begitu pengunjung menggeser sendiri.
      */
      const current = Math.round(element.scrollLeft / element.clientWidth)
      goTo((current + 1) % count)
    }, intervalMs)

    // Wajib: timer dihentikan saat komponen dilepas atau saat dijeda.
    return () => clearInterval(timer)
  }, [ref, count, isPaused, intervalMs, goTo])

  return { index, goTo }
}
