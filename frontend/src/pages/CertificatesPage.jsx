import BackLink from '../components/ui/BackLink'
import CertificateCard from '../components/ui/CertificateCard'
import Container from '../components/ui/Container'
import { CERTIFICATES } from '../data/certificates'

/*
  CertificatesPage — semua pelatihan dan sertifikasi (alamat "/certificates").

  Beranda hanya menampilkannya sebagai deretan bergerak; halaman ini
  menampilkan semuanya sekaligus supaya mudah ditelusuri.

  Kartunya sama dengan yang di beranda, hanya tingkat judulnya 2 karena
  di sini judul halaman (h1) ada di atasnya.
*/
function CertificatesPage() {
  return (
    <>
      <title>Pelatihan & Sertifikasi — Deco Mahendra</title>
      <meta
        name="description"
        content="Daftar pelatihan, seminar, dan sertifikasi yang diikuti Deco Mahendra."
      />

      <Container>
        <div className="pt-32 pb-24 md:pt-40 md:pb-32">
          <BackLink fallbackTo="/" fallbackLabel="Beranda" />

          <p className="mt-6 font-mono text-eyebrow uppercase tracking-[0.22em] text-accent">
            Certificates
          </p>

          <h1 className="mt-5 max-w-3xl font-display text-title font-bold leading-[1.05] tracking-tight text-heading">
            Pelatihan &amp; sertifikasi
          </h1>

          <p className="mt-6 max-w-xl text-lg leading-relaxed text-body">
            Kegiatan yang saya ikuti maupun isi, di dalam dan di luar kampus.
          </p>

          {CERTIFICATES.length > 0 ? (
            <ul className="mt-16 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
              {CERTIFICATES.map((certificate) => (
                <li key={certificate.id}>
                  <CertificateCard certificate={certificate} headingLevel={2} />
                </li>
              ))}
            </ul>
          ) : (
            <p className="mt-16 rounded-card border border-dashed border-line px-6 py-16 text-center text-faint">
              Belum ada sertifikat yang ditampilkan.
            </p>
          )}
        </div>
      </Container>
    </>
  )
}

export default CertificatesPage
