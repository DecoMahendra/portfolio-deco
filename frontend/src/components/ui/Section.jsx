import Container from './Container'

/*
  Section — kerangka standar untuk setiap bagian halaman (About, Skills, dst).

  Menyeragamkan tiga hal:
  1. Jarak atas-bawah antar section
  2. Susunan label kecil -> judul -> deskripsi
  3. Kaitan aksesibilitas: aria-labelledby menghubungkan <section> dengan judulnya,
     sehingga pembaca layar bisa menyebutkan "Section About" saat pengguna
     tunanetra melompat antar bagian.

  Props:
  - id          : penanda section, dipakai navbar untuk melompat ke sini
  - eyebrow     : label kecil di atas judul, contoh "01 — About"
  - title       : judul section
  - description : paragraf pengantar (opsional)
  - children    : isi utama section (opsional)
*/
function Section({ id, eyebrow, title, description, children, className = '' }) {
  const headingId = `${id}-heading`

  return (
    <section
      id={id}
      aria-labelledby={headingId}
      className={`py-24 md:py-32 ${className}`}
    >
      <Container>
        {eyebrow && (
          <p className="mb-5 font-mono text-eyebrow uppercase tracking-[0.22em] text-accent">
            {eyebrow}
          </p>
        )}

        <h2
          id={headingId}
          className="font-display text-title font-bold leading-[1.05] tracking-tight text-heading"
        >
          {title}
        </h2>

        {description && (
          <p className="mt-6 max-w-2xl text-lg leading-relaxed text-body">
            {description}
          </p>
        )}

        {children && <div className="mt-12">{children}</div>}
      </Container>
    </section>
  )
}

export default Section
