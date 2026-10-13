import Section from '../ui/Section'
import { cloudinaryImage } from '../../data/cloudinary'
import { PROFILE } from '../../data/profile'

/*
  About — cerita singkat tentang pemilik portfolio.

  Memakai ulang component Section (dari Phase 2) supaya jarak, label kecil,
  dan judulnya seragam dengan section lain. Yang ditulis di sini hanya isinya.

  Susunannya dua kolom di layar lebar (foto | teks) dan menumpuk ke bawah di HP.
*/
function About() {
  return (
    <Section
      id="about"
      eyebrow="01 — About"
      title="Tentang saya"
      className="border-t border-line-soft"
    >
      {/* md:grid-cols-[16rem_1fr] artinya: kolom pertama (foto) lebarnya tetap
          16rem, kolom kedua (teks) mengisi sisa ruang yang ada. */}
      <div className="grid gap-10 md:grid-cols-[16rem_1fr] md:gap-14">
        {/* ---------- KOLOM FOTO ---------- */}
        <div>
          {/* Foto hanya datang dari dashboard admin (diunggah ke Cloudinary).

              800x800: ukuran yang diminta dari Cloudinary, sama dengan
              width & height di bawah. Gunanya memberi tahu browser
              perbandingan sisi gambar sejak awal, supaya ruangnya sudah
              disiapkan dan halaman tidak "melompat" saat gambar selesai dimuat.

              fit 'fill' + aspect-square + object-cover: kotaknya selalu persegi.
              Foto yang bentuknya lain dipotong ke tengah, bukan digepengkan
              atau diberi pinggiran berwarna.

              loading="lazy" menunda pengunduhan foto sampai pengunjung
              scroll mendekat. Foto ini letaknya di bawah layar pertama, jadi
              tidak perlu ikut antre saat halaman pertama kali dibuka.

              bg-surface memberi warna gelap di belakang foto. Selama foto
              belum selesai dimuat, yang terlihat adalah kotak bertema gelap
              dengan sudut melengkung — bukan ruang kosong. */}
          {PROFILE.photo ? (
            <img
              src={cloudinaryImage(PROFILE.photo, 800, 800, { fit: 'fill' })}
              alt={PROFILE.photoAlt}
              width="800"
              height="800"
              loading="lazy"
              className="aspect-square w-full rounded-card border border-line bg-surface object-cover"
            />
          ) : (
            /*
              Belum ada foto yang diunggah: kotak persegi berikon orang, sama
              seperti ikon pengganti di kartu sertifikat. Ukuran dan sudutnya
              sama dengan foto, jadi tata letaknya tidak bergeser. aria-hidden
              karena hanya hiasan — tidak ada isi yang perlu dibacakan.
            */
            <div
              aria-hidden="true"
              className="flex aspect-square w-full items-center justify-center rounded-card border border-line bg-surface"
            >
              <svg
                width="64"
                height="64"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                strokeWidth="1.25"
                strokeLinecap="round"
                strokeLinejoin="round"
                className="text-line"
              >
                <circle cx="12" cy="8" r="4" />
                <path d="M4 21c0-4.4 3.6-8 8-8s8 3.6 8 8" />
              </svg>
            </div>
          )}
        </div>

        {/* ---------- KOLOM TEKS ---------- */}
        <div>
          <div className="space-y-5">
            {PROFILE.bio.map((paragraph) => (
              /* Paragraf dipakai sebagai key karena isinya unik dan urutannya
                 tidak berubah-ubah saat halaman berjalan. */
              <p key={paragraph} className="text-lg leading-relaxed text-body">
                {paragraph}
              </p>
            ))}
          </div>

          {/* Keterangan singkat. <dl> dipakai karena isinya pasangan
              istilah dan penjelasan — lebih tepat daripada <div> biasa. */}
          <dl className="mt-10 flex flex-wrap gap-x-12 gap-y-6 border-t border-line-soft pt-8">
            <div>
              <dt className="font-mono text-eyebrow uppercase tracking-[0.22em] text-faint">
                Lokasi
              </dt>
              <dd className="mt-2 font-display font-bold text-heading">
                {PROFILE.location}
              </dd>
            </div>
            <div>
              <dt className="font-mono text-eyebrow uppercase tracking-[0.22em] text-faint">
                Fokus
              </dt>
              <dd className="mt-2 font-display font-bold text-heading">
                {PROFILE.role}
              </dd>
            </div>
          </dl>
        </div>
      </div>
    </Section>
  )
}

export default About
