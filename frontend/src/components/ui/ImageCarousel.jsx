import { useRef, useState } from 'react'
import { cloudinaryImage } from '../../data/cloudinary'
import { useCarousel } from '../../hooks/useCarousel'

/*
  ImageCarousel — slide gambar yang berganti sendiri, di halaman detail project.

  Geserannya memakai scroll-snap bawaan browser: tiap gambar "menempel" pas di
  tengah saat digeser, tanpa perlu kode tambahan. Perpindahan otomatis, tombol
  panah, dan titik penanda semuanya menggerakkan posisi gulir yang sama.

  Berhenti sementara saat kursor di atasnya, saat sedang ditekan/ditahan jari,
  dan saat salah satu tombolnya disorot keyboard. Untuk pengunjung yang
  mematikan animasi: tidak berpindah sendiri, dan perpindahannya tidak meluncur.

  images : daftar { url, alt } — alt boleh null
  label  : nama project, dipakai menyusun teks pengganti gambar
*/
function ImageCarousel({ images, label }) {
  const trackRef = useRef(null)

  // Tiga alasan berhenti dicatat terpisah — lihat penjelasan di ProjectMarquee.
  const [isHovered, setIsHovered] = useState(false)
  const [isPressed, setIsPressed] = useState(false)
  const [hasFocus, setHasFocus] = useState(false)

  const { index, goTo } = useCarousel(trackRef, {
    count: images.length,
    isPaused: isHovered || isPressed || hasFocus,
  })

  const handleLeave = () => {
    setIsHovered(false)
    setIsPressed(false)
  }

  // Berputar: dari gambar terakhir, tombol "berikutnya" kembali ke gambar pertama.
  const step = (arah) => goTo((index + arah + images.length) % images.length)

  const hasControls = images.length > 1

  return (
    <div
      onPointerEnter={() => setIsHovered(true)}
      onPointerLeave={handleLeave}
      onPointerDown={() => setIsPressed(true)}
      onPointerUp={() => setIsPressed(false)}
      onPointerCancel={() => setIsPressed(false)}
      onFocusCapture={() => setHasFocus(true)}
      onBlurCapture={() => setHasFocus(false)}
    >
      {/*
        snap-x snap-mandatory: tiap gambar berhenti pas di tempatnya saat digeser.
        tabIndex: area yang bisa digeser harus bisa dijangkau keyboard,
        supaya bisa digeser dengan tombol panah.
      */}
      <div
        ref={trackRef}
        tabIndex={0}
        role="group"
        aria-label={`Galeri gambar ${label}`}
        className="flex snap-x snap-mandatory overflow-x-auto rounded-card border border-line bg-raised [scrollbar-width:none] [&::-webkit-scrollbar]:hidden"
      >
        {images.map((image, position) => (
          <figure key={image.url} className="w-full shrink-0 snap-center">
            <img
              src={cloudinaryImage(image.url, 1280, 640)}
              /*
                Teks pengganti gambar. Kalau tidak diisi dari dashboard admin,
                disusun otomatis supaya pembaca layar tetap tahu ini gambar
                keberapa — bukan hanya "gambar" berulang kali.
              */
              alt={image.alt || `Tampilan ${label}, gambar ${position + 1} dari ${images.length}`}
              width="1280"
              height="640"
              // Gambar pertama dimuat lebih dulu karena langsung terlihat.
              loading={position === 0 ? 'eager' : 'lazy'}
              className="aspect-[2/1] w-full object-cover"
            />
          </figure>
        ))}
      </div>

      {hasControls && (
        /*
          Baris kendali di BAWAH gambar, bukan menumpuk di atasnya: tombol yang
          menumpuk menutupi bagian gambar yang justru ingin ditunjukkan.

          Panah hanya muncul mulai layar sedang (md:). Di HP, menggeser dengan
          jari sudah lebih alami, dan tombol tambahan hanya memakan ruang.
        */
        <div className="mt-5 flex items-center justify-center gap-2">
          <button
            type="button"
            onClick={() => step(-1)}
            aria-label="Gambar sebelumnya"
            className="hidden size-11 shrink-0 items-center justify-center rounded-full border border-line text-heading transition-colors hover:border-accent hover:text-accent motion-reduce:transition-none md:flex"
          >
            <span aria-hidden="true">&larr;</span>
          </button>

          {/* flex-wrap: jumlah gambar tidak dibatasi, jadi kalau titiknya banyak
              barisnya turun ke bawah — bukan melebar melewati layar. */}
          <div className="flex flex-wrap items-center justify-center gap-2">
            {images.map((image, position) => (
              <button
                key={image.url}
                type="button"
                onClick={() => goTo(position)}
                aria-label={`Gambar ${position + 1} dari ${images.length}`}
                aria-current={position === index ? 'true' : undefined}
                /* Kotak sentuhnya 44px (p-2 + tinggi titik), memenuhi ukuran
                   minimal area sentuh, tapi titiknya sendiri tetap kecil. */
                className="group p-2"
              >
                <span
                  aria-hidden="true"
                  className={`block h-1.5 rounded-full transition-all duration-300 ease-out-expo motion-reduce:transition-none ${
                    position === index
                      ? 'w-6 bg-accent'
                      : 'w-1.5 bg-line group-hover:bg-faint'
                  }`}
                />
              </button>
            ))}
          </div>

          <button
            type="button"
            onClick={() => step(1)}
            aria-label="Gambar berikutnya"
            className="hidden size-11 shrink-0 items-center justify-center rounded-full border border-line text-heading transition-colors hover:border-accent hover:text-accent motion-reduce:transition-none md:flex"
          >
            <span aria-hidden="true">&rarr;</span>
          </button>
        </div>
      )}
    </div>
  )
}

export default ImageCarousel
