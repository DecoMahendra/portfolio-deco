import { useEffect, useRef, useState } from 'react'

/*
  useInView — memberi tahu apakah sebuah elemen sudah masuk ke layar.

  Dipakai untuk memunculkan section secara halus saat pengunjung scroll,
  bukan langsung terlihat semua sejak awal.

  Memakai IntersectionObserver, fitur bawaan browser yang sama seperti di
  useActiveSection. Jauh lebih ringan daripada memantau event scroll, karena
  hanya berjalan saat ada perubahan.

  Cara pakainya:
    const { ref, isInView } = useInView()
    <div ref={ref} className={isInView ? 'opacity-100' : 'opacity-0'}>
*/
export function useInView() {
  const ref = useRef(null)
  const [isInView, setIsInView] = useState(false)

  useEffect(() => {
    const element = ref.current
    if (!element) return

    const observer = new IntersectionObserver(
      ([entry]) => {
        if (!entry.isIntersecting) return

        setIsInView(true)

        // Sekali muncul, tidak perlu dipantau lagi. Menghentikannya di sini
        // mencegah section berkedip hilang-muncul saat pengunjung scroll
        // naik-turun berulang kali.
        observer.disconnect()
      },
      {
        // Section dianggap "masuk layar" setelah melewati 10% bagian bawah,
        // supaya animasinya mulai saat elemen benar-benar terlihat —
        // bukan saat ujungnya baru sedikit menyembul.
        rootMargin: '0px 0px -10% 0px',
      },
    )

    observer.observe(element)

    // Wajib ada. Menghentikan pemantauan saat komponen dilepas dari halaman,
    // supaya tidak membocorkan memori.
    return () => observer.disconnect()
  }, [])

  return { ref, isInView }
}
