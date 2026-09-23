import CertificateCard from './CertificateCard'
import Marquee from './Marquee'

/*
  CertificateMarquee — deretan kartu sertifikat di beranda.

  Gerakan, jeda, dan putarannya diurus komponen Marquee, sama seperti deretan
  project. Kartu sertifikat bukan tautan, jadi tidak perlu diatur soal Tab.
*/
function CertificateMarquee({ certificates }) {
  return (
    <Marquee ariaLabel="Daftar pelatihan dan sertifikasi, bergeser otomatis">
      {() =>
        certificates.map((certificate) => (
          <li key={certificate.id} className="w-64 shrink-0 md:w-72">
            <CertificateCard certificate={certificate} />
          </li>
        ))
      }
    </Marquee>
  )
}

export default CertificateMarquee
