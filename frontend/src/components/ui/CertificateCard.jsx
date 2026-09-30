import { cloudinaryImage } from '../../data/cloudinary'

/*
  CertificateCard — kartu satu pelatihan/sertifikasi.

  Kartunya menyesuaikan isi: kalau gambar sertifikatnya sudah diunggah lewat
  dashboard admin, gambar itu yang tampil. Kalau belum, tahunnya dicetak besar
  sebagai penggantinya — supaya kartu tetap punya "wajah", bukan kotak kosong.

  Tidak dibuat sebagai tautan karena sertifikat tidak punya halaman detail:
  semua isinya sudah tampil di kartu ini.

  headingLevel: di beranda 3 (di bawah judul section h2), di halaman
  /certificates 2 (di bawah judul halaman h1) — supaya urutan judul tidak melompat.
*/
function CertificateCard({ certificate, headingLevel = 3 }) {
  const Heading = `h${headingLevel}`

  return (
    <article className="flex h-full flex-col overflow-hidden rounded-card border border-line bg-surface">
      {/* aspect-[4/3] memesan tempat sebelum gambar dimuat, supaya halaman
          tidak melompat. 4:3 dipilih karena sertifikat umumnya berbentuk
          lembaran, bukan memanjang seperti tangkapan layar website. */}
      <div className="aspect-[4/3] overflow-hidden border-b border-line bg-raised">
        {certificate.image ? (
          <img
            src={cloudinaryImage(certificate.image, 600, 450)}
            /* alt kosong: nama sertifikat tepat di bawahnya sudah menjelaskan
               gambar ini. Kalau diisi juga, pembaca layar menyebutnya dua kali. */
            alt=""
            width="600"
            height="450"
            loading="lazy"
            className="h-full w-full object-cover"
          />
        ) : (
          /*
            Belum ada gambar: ikon sertifikat sebagai pengganti sementara.
            Dulu di sini tahunnya dicetak besar, tapi warnanya terlalu redup
            untuk teks (kontras 1,18 — minimal 3:1), sedangkan menerangkannya
            membuat tahun tampil dua kali di kartu yang sama. Ikon dekoratif
            tidak terikat aturan kontras teks dan tetap kalem.

            Begitu gambar diunggah lewat dashboard admin, ikon ini digantikan
            gambar itu secara otomatis.
          */
          <div aria-hidden="true" className="flex h-full items-center justify-center">
            <svg
              width="56"
              height="56"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              strokeWidth="1.25"
              strokeLinecap="round"
              strokeLinejoin="round"
              className="text-line"
            >
              {/* Lembaran sertifikat dengan pita di bawahnya. */}
              <path d="M4 4h16v11H4z" />
              <path d="M8 8h8M8 11h5" />
              <path d="M9 15v5l3-2 3 2v-5" />
            </svg>
          </div>
        )}
      </div>

      <div className="flex flex-1 flex-col p-6">
        <p className="font-mono text-eyebrow uppercase tracking-[0.22em] text-accent">
          {certificate.year}
        </p>

        <Heading className="mt-3 font-display text-lg font-bold leading-snug text-heading">
          {certificate.name}
        </Heading>

        {/* mt-auto mendorong nama penyelenggara ke dasar kartu, sejajar antar kartu. */}
        <p className="mt-auto pt-4 text-sm text-body">{certificate.organizer}</p>
      </div>
    </article>
  )
}

export default CertificateCard
