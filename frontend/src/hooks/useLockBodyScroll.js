import { useEffect } from 'react'

/*
  useLockBodyScroll — mengunci scroll halaman selama menu mobile terbuka.

  Tanpa ini, saat menu layar penuh terbuka lalu pengguna menggeser layar,
  halaman di belakang menu ikut ter-scroll. Terasa seperti bug.
*/
export function useLockBodyScroll(isLocked) {
  useEffect(() => {
    if (!isLocked) return

    // Simpan nilai aslinya dulu, supaya bisa dikembalikan persis seperti semula.
    const originalOverflow = document.body.style.overflow
    document.body.style.overflow = 'hidden'

    return () => {
      document.body.style.overflow = originalOverflow
    }
  }, [isLocked])
}
