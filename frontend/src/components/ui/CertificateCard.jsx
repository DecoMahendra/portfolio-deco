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
          <div
            aria-hidden="true"
            className="flex h-full items-center justify-center px-6 text-center font-display text-3xl font-bold leading-tight text-line"
          >
            {certificate.year}
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
