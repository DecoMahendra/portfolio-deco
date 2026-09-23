import { useRef, useState } from 'react'
import ProjectCard from './ProjectCard'
import { useAutoScroll } from '../../hooks/useAutoScroll'

/*
  ProjectMarquee — deretan kartu project yang bergeser sendiri ke kiri,
  dan juga bisa digeser sendiri oleh pengunjung.

  Isinya ditulis DUA kali berdampingan. Saat geseran melewati salinan pertama,
  posisinya dimundurkan tepat satu salinan (lihat useAutoScroll) — karena isinya
  sama persis, perpindahannya tidak terlihat dan putarannya terasa tanpa ujung.

  Berhenti sementara saat:
  - kursor berada di atasnya (desktop)
  - salah satu kartu disorot dengan Tab, atau deretannya sendiri disorot
  - sedang disentuh/ditahan jari atau tombol mouse ditekan

  Untuk pengunjung yang mematikan animasi di perangkatnya: tidak bergerak
  sendiri sama sekali, tapi tetap bisa digeser manual.
*/

/*
  Satu salinan harus lebih lebar dari area tampilnya, supaya saat putaran
  berulang tidak muncul ruang kosong. Area tampil maksimal ±67rem, satu kartu
  beserta jaraknya ±21,5rem -> minimal 4 kartu. Kalau project belum sebanyak
  itu, sisanya diisi kartu "Coming soon".
*/
const MIN_CARDS = 4

function ProjectMarquee({ projects }) {
  const trackRef = useRef(null)

  /*
    Tiga alasan berhenti dicatat terpisah, bukan digabung jadi satu penanda.
    Kalau digabung, melepas tombol mouse akan menjalankan gerakan lagi padahal
    kursor masih di atas deretan — kartunya bergeser menjauh dan klik meleset.
    Dengan dipisah, gerakan baru jalan kalau ketiganya sudah tidak berlaku.
  */
  const [isHovered, setIsHovered] = useState(false)
  const [isPressed, setIsPressed] = useState(false)
  const [hasFocus, setHasFocus] = useState(false)

  useAutoScroll(trackRef, {
    pixelsPerSecond: 40,
    isPaused: isHovered || isPressed || hasFocus,
  })

  const fillerCount = Math.max(0, MIN_CARDS - projects.length)

  // Kursor/jari meninggalkan area: tekanan ikut dianggap selesai, karena
  // pointerup-nya bisa terjadi di luar area dan tidak sampai ke sini.
  const handleLeave = () => {
    setIsHovered(false)
    setIsPressed(false)
  }

  /*
    isCopy = salinan kedua, hanya untuk melanjutkan putaran.

    aria-hidden: pembaca layar tidak membacanya dua kali.
    Kartunya dibuat tidak bisa disorot Tab (isFocusable false) — wajib, karena
    isi aria-hidden tidak boleh bisa disorot keyboard.

    Sengaja TIDAK memakai inert: inert juga mematikan klik, sehingga kartu dari
    salinan kedua terlihat normal tapi tidak bisa diklik.
  */
  const renderCards = (isCopy) => (
    <ul
      aria-hidden={isCopy || undefined}
      // pr-6 = jarak yang sama dengan gap-6, supaya sambungan antar salinan
      // berjarak sama dengan antar kartu.
      className="flex shrink-0 gap-6 pr-6"
    >
      {projects.map((project) => (
        <li key={project.id} className="w-72 shrink-0 md:w-80">
          <ProjectCard project={project} isFocusable={!isCopy} />
        </li>
      ))}

      {/* Kartu pengisi identik dan urutannya tidak pernah berubah, jadi nomor
          urut aman dipakai sebagai key. aria-hidden karena hanya pengisi ruang. */}
      {Array.from({ length: fillerCount }, (_, index) => (
        <li key={`coming-soon-${index}`} aria-hidden="true" className="w-72 shrink-0 md:w-80">
          <div className="flex h-full min-h-80 flex-col items-center justify-center gap-3 rounded-card border border-dashed border-line p-6 text-center">
            <span className="font-mono text-eyebrow uppercase tracking-[0.22em] text-accent">
              Coming soon
            </span>
            <span className="text-sm text-faint">Project berikutnya sedang dikerjakan.</span>
          </div>
        </li>
      ))}
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
      aria-label="Daftar project, bergeser otomatis"
      onPointerEnter={() => setIsHovered(true)}
      onPointerLeave={handleLeave}
      onPointerDown={() => setIsPressed(true)}
      onPointerUp={() => setIsPressed(false)}
      onPointerCancel={() => setIsPressed(false)}
      onFocusCapture={() => setHasFocus(true)}
      onBlurCapture={() => setHasFocus(false)}
      className="group overflow-x-auto [scrollbar-width:none] [&::-webkit-scrollbar]:hidden [mask-image:linear-gradient(to_right,transparent,black_6%,black_94%,transparent)] select-none [-webkit-touch-callout:none] focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-accent"
    >
      <div className="flex w-max">
        {renderCards(false)}
        {renderCards(true)}
      </div>
    </div>
  )
}

export default ProjectMarquee
