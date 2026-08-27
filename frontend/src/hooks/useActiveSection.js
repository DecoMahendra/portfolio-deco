import { useEffect, useState } from 'react'

/*
  useActiveSection — menentukan section mana yang sedang dilihat pengunjung.

  Dipakai navbar untuk menyalakan menu yang sesuai saat halaman di-scroll.

  Cara kerjanya memakai IntersectionObserver: sebuah fitur bawaan browser yang
  memberi tahu kita kapan sebuah elemen masuk atau keluar layar.

  Kenapa tidak pakai event 'scroll' biasa?
  Event scroll berjalan puluhan kali per detik dan bisa membuat halaman tersendat.
  IntersectionObserver hanya berjalan saat ada perubahan, jadi jauh lebih ringan.
*/
export function useActiveSection(sectionIds) {
  const [activeId, setActiveId] = useState('')

  useEffect(() => {
    // Ubah daftar id menjadi daftar elemen HTML yang sebenarnya.
    // filter(Boolean) membuang id yang section-nya belum dibuat.
    const elements = sectionIds
      .map((id) => document.getElementById(id))
      .filter(Boolean)

    if (elements.length === 0) return

    const observer = new IntersectionObserver(
      (entries) => {
        const visible = entries.filter((entry) => entry.isIntersecting)
        if (visible.length === 0) return

        // Kalau dua section terlihat bersamaan, pilih yang posisinya paling atas.
        const topMost = visible.reduce((a, b) =>
          a.boundingClientRect.top < b.boundingClientRect.top ? a : b,
        )

        setActiveId(topMost.target.id)
      },
      {
        // rootMargin memperkecil "area pantau" menjadi hanya pita tipis
        // di tengah layar. Efeknya: menu berganti saat section sampai ke
        // tengah layar, bukan saat ujungnya baru sedikit terlihat.
        rootMargin: '-45% 0px -45% 0px',
        threshold: 0,
      },
    )

    elements.forEach((element) => observer.observe(element))

    // Fungsi ini dijalankan saat komponen dilepas dari halaman.
    // Wajib ada, supaya pemantauan berhenti dan tidak membocorkan memori.
    return () => observer.disconnect()
  }, [sectionIds])

  return activeId
}
