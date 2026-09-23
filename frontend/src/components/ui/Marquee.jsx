import { useRef, useState } from 'react'
import { useAutoScroll } from '../../hooks/useAutoScroll'

/*
  Marquee — deretan kartu yang bergeser sendiri ke kiri, dan juga bisa digeser
  sendiri oleh pengunjung. Dipakai untuk project dan sertifikat di beranda.

  Isinya ditulis DUA kali berdampingan. Saat geseran melewati salinan pertama,
  posisinya dimundurkan tepat satu salinan (lihat useAutoScroll) — karena isinya
  sama persis, perpindahannya tidak terlihat dan putarannya terasa tanpa ujung.

  Berhenti sementara saat:
  - kursor berada di atasnya (desktop)
  - salah satu kartu atau deretannya sendiri disorot dengan Tab
  - sedang disentuh/ditahan jari atau tombol mouse ditekan

  Untuk pengunjung yang mematikan animasi di perangkatnya: tidak bergerak
  sendiri sama sekali, tapi tetap bisa digeser manual.

  Cara memakainya: children diisi FUNGSI, bukan langsung kartu-kartunya.
  Marquee memanggil fungsi itu dua kali — sekali untuk salinan asli, sekali
  untuk salinan kedua — dan memberi tahu yang mana lewat isCopy:

    <Marquee ariaLabel="Daftar project, bergeser otomatis">
      {(isCopy) => projects.map((p) => (
        <li key={p.id}><ProjectCard project={p} isFocusable={!isCopy} /></li>
      ))}
    </Marquee>

  isCopy dipakai supaya kartu di salinan kedua dilewati tombol Tab — kalau
  tidak, Tab akan berhenti dua kali di kartu yang sama.
*/
function Marquee({ ariaLabel, children }) {
  const trackRef = useRef(null)

  /*
    Tiga alasan berhenti dicatat terpisah, bukan digabung jadi satu penanda.
    Kalau digabung, melepas tombol mouse akan menjalankan gerakan lagi padahal
    kursor masih di atas deretan — kartunya bergeser menjauh dan klik meleset.
  */
  const [isHovered, setIsHovered] = useState(false)
  const [isPressed, setIsPressed] = useState(false)
  const [hasFocus, setHasFocus] = useState(false)

  useAutoScroll(trackRef, {
    pixelsPerSecond: 40,
    isPaused: isHovered || isPressed || hasFocus,
  })

  // Kursor/jari meninggalkan area: tekanan ikut dianggap selesai, karena
  // pointerup-nya bisa terjadi di luar area dan tidak sampai ke sini.
  const handleLeave = () => {
    setIsHovered(false)
    setIsPressed(false)
  }

  /*
    aria-hidden pada salinan kedua: pembaca layar tidak membacanya dua kali.

    Sengaja TIDAK memakai inert: inert juga mematikan klik, sehingga kartu dari
    salinan kedua terlihat normal tapi tidak bisa diklik.
  */
  const renderCopy = (isCopy) => (
    <ul
      aria-hidden={isCopy || undefined}
      // pr-6 = jarak yang sama dengan gap-6, supaya sambungan antar salinan
      // berjarak sama dengan antar kartu.
      className="flex shrink-0 gap-6 pr-6"
    >
      {children(isCopy)}
    </ul>
  )

  return (
    /*
      tabIndex & role: kotak yang isinya bisa digeser harus bisa dijangkau
      keyboard, supaya penggunanya bisa menggeser dengan tombol panah.

      overflow-x-auto : yang membuat isinya bisa digeser (otomatis maupun manual)
      scrollbar disembunyikan: batang gulirnya akan memotong tampilan kartu
      touch-callout & select-none: menahan jari tidak memunculkan menu
      mask-image      : kedua tepi memudar, kartu terlihat masuk dan keluar halus
    */
    <div
      ref={trackRef}
      tabIndex={0}
      role="group"
      aria-label={ariaLabel}
      onPointerEnter={() => setIsHovered(true)}
      onPointerLeave={handleLeave}
      onPointerDown={() => setIsPressed(true)}
      onPointerUp={() => setIsPressed(false)}
      onPointerCancel={() => setIsPressed(false)}
      onFocusCapture={() => setHasFocus(true)}
      onBlurCapture={() => setHasFocus(false)}
      className="overflow-x-auto [scrollbar-width:none] [&::-webkit-scrollbar]:hidden [mask-image:linear-gradient(to_right,transparent,black_6%,black_94%,transparent)] select-none [-webkit-touch-callout:none] focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-accent"
    >
      <div className="flex w-max">
        {renderCopy(false)}
        {renderCopy(true)}
      </div>
    </div>
  )
}

export default Marquee
