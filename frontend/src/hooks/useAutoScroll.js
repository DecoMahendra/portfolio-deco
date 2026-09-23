import { useEffect } from 'react'

/*
  useAutoScroll — menggeser isi sebuah kotak ke samping sedikit demi sedikit,
  terus-menerus, sekaligus membiarkannya tetap bisa digeser manual.

  Kenapa tidak memakai animasi CSS saja?
  Animasi CSS memindahkan posisi gambar di layar, bukan posisi gulirnya. Isinya
  jadi tidak bisa digeser dengan jari atau roda mouse. Dengan mengubah posisi
  gulir (scrollLeft), gerakan otomatis dan geseran manual memakai "kemudi" yang
  sama, jadi keduanya bisa hidup berdampingan.

  Putaran tanpa ujung: isi kotak ditulis dua kali berdampingan. Begitu geseran
  melewati satu salinan, posisinya dimundurkan tepat satu salinan — isinya sama
  persis, jadi perpindahannya tidak terlihat. Berlaku dua arah.

  pixelsPerSecond dihitung dari waktu antar frame, bukan per frame, supaya
  kecepatannya sama di layar 60Hz maupun 120Hz.
*/
export function useAutoScroll(ref, { pixelsPerSecond = 40, isPaused = false } = {}) {
  // Putaran tanpa ujung: berlaku juga saat digeser manual dan saat berhenti.
  useEffect(() => {
    const element = ref.current
    if (!element) return

    const wrapAround = () => {
      const oneCopy = element.scrollWidth / 2
      if (oneCopy === 0) return

      if (element.scrollLeft >= oneCopy) element.scrollLeft -= oneCopy
      else if (element.scrollLeft <= 0) element.scrollLeft += oneCopy
    }

    element.addEventListener('scroll', wrapAround)
    return () => element.removeEventListener('scroll', wrapAround)
  }, [ref])

  // Gerakan otomatis.
  useEffect(() => {
    const element = ref.current
    if (!element || isPaused) return

    // Pengunjung yang mematikan animasi: tidak digerakkan sama sekali,
    // tapi tetap bisa digeser sendiri.
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return

    let frame
    let previousTime

    const step = (time) => {
      if (previousTime !== undefined) {
        /*
          Disimpan sebagai angka pecahan lalu diberikan sekaligus. Kalau
          langsung "scrollLeft += 0.6", sebagian browser membulatkannya ke 0
          dan geserannya tidak pernah jalan.
        */
        element.scrollLeft += (pixelsPerSecond * (time - previousTime)) / 1000
      }

      previousTime = time
      frame = requestAnimationFrame(step)
    }

    frame = requestAnimationFrame(step)

    // Wajib: menghentikan gerakan saat komponen dilepas atau saat dijeda.
    return () => cancelAnimationFrame(frame)
  }, [ref, pixelsPerSecond, isPaused])
}
