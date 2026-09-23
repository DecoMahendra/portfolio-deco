import { Link } from 'react-router'
import CertificateMarquee from '../ui/CertificateMarquee'
import Section from '../ui/Section'
import { CERTIFICATES } from '../../data/certificates'

/*
  Certificates — pelatihan dan sertifikasi.

  Dulu menempel di bawah section Projects. Dipisah jadi section sendiri supaya
  punya menu di navbar dan tidak tenggelam di bawah daftar karya.

  Bentuknya sama seperti Projects: deretan kartu yang bergeser, lalu tautan ke
  halaman yang memuat semuanya. Isinya dari src/data/certificates.js.
*/
function Certificates() {
  return (
    <Section
      id="certificates"
      eyebrow="04 — Certificates"
      title="Pelatihan & sertifikasi"
      className="border-t border-line-soft"
    >
      <CertificateMarquee certificates={CERTIFICATES} />

      <Link
        to="/certificates"
        className="group mt-8 inline-flex items-center gap-2 font-semibold text-heading transition-colors hover:text-accent motion-reduce:transition-none"
      >
        Lihat semua sertifikat
        <span
          aria-hidden="true"
          className="transition-transform duration-200 ease-out-expo group-hover:translate-x-1 motion-reduce:transition-none"
        >
          &rarr;
        </span>
      </Link>
    </Section>
  )
}

export default Certificates
