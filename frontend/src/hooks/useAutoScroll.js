import { useEffect, useState } from 'react'

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

  Gerakannya hanya hidup saat kotaknya benar-benar terlihat di layar.
*/
export function useAutoScroll(ref, { pixelsPerSecond = 40, isPaused = false } = {}) {
  // Putaran tanpa ujung: berlaku juga saat digeser manual dan saat berhenti.
  useEffect(() => {
    const element = ref.current
    if (!element) return

    const wrapAround = () => {
      const oneCopy = element.scrollWidth / 2
      if (oneCopy === 0) return

      /*
        Jangan melompat selama ada yang sedang disorot keyboard di dalamnya.
        Saat Tab masuk ke sebuah kartu, browser menggulir supaya kartu itu
        terlihat. Kalau kita ikut melompatkan posisinya, kartunya pindah
        tempat, browser menggulir lagi, dan keduanya saling berebut —
        tampil sebagai kedap-kedip.
      */
      if (element.contains(document.activeElement)) return

      if (element.scrollLeft >= oneCopy) element.scrollLeft -= oneCopy
      else if (element.scrollLeft <= 0) element.scrollLeft += oneCopy
    }

    element.addEventListener('scroll', wrapAround)
    return () => element.removeEventListener('scroll', wrapAround)
  }, [ref])

  /*
    Terlihat di layar atau tidak.

    Tanpa ini gerakannya tetap berjalan walaupun pengunjung sedang membaca
    bagian lain halaman: tidak ada yang melihatnya, tapi tenaga baterai dan
    waktu kerja browser tetap terpakai. Di beranda ada dua deretan sekaligus.

    Nilai awalnya false — IntersectionObserver langsung melapor begitu dipasang,
    jadi yang memang sedang terlihat akan menyala sesaat kemudian.
  */
  const [isVisible, setIsVisible] = useState(false)

  useEffect(() => {
    const element = ref.current
    if (!element) return

    const observer = new IntersectionObserver(([entry]) => setIsVisible(entry.isIntersecting))
    observer.observe(element)

    // Wajib: tanpa ini pengamatnya tertinggal saat komponen dilepas.
    return () => observer.disconnect()
  }, [ref])

  // Gerakan otomatis.
  useEffect(() => {
    const element = ref.current
    if (!element || isPaused || !isVisible) return

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
  }, [ref, pixelsPerSecond, isPaused, isVisible])
}
