import Section from '../ui/Section'
import { CONTACT_LINKS } from '../../data/contact'

/*
  Contact — bagian penutup halaman.

  Tanpa form isian. Form yang benar-benar mengirim pesan butuh backend, dan
  Laravel baru dikerjakan di Phase 9+. Form yang terlihat berfungsi padahal
  pesannya tidak ke mana-mana lebih merugikan daripada tidak ada form sama
  sekali: pengunjung mengira sudah menghubungi, lalu menunggu balasan yang
  tidak akan pernah datang.

  Isinya diambil dari src/data/contact.js.
*/
function Contact() {
  return (
    <Section
      id="contact"
      eyebrow="04 — Contact"
      title="Mari bekerja sama"
      description="Terbuka untuk project freelance, diskusi teknis, atau sekadar bertukar pikiran soal pengembangan web. Silakan hubungi lewat salah satu tautan di bawah."
      className="border-t border-line-soft"
    >
      <ul>
        {CONTACT_LINKS.map((item) => {
          /* Tautan email dibuka oleh aplikasi email, bukan tab baru.
             Membukanya di tab baru justru meninggalkan tab kosong yang
             membingungkan. Jadi target="_blank" hanya untuk tautan web. */
          const isExternal = !item.href.startsWith('mailto:')

          return (
            <li
              key={item.label}
              className="grid gap-1 border-t border-line-soft py-6 md:grid-cols-[11rem_1fr] md:items-baseline md:gap-10"
            >
              <span className="font-mono text-eyebrow uppercase tracking-[0.18em] text-faint">
                {item.label}
              </span>

              {/* Yang bisa diklik hanya teks nilainya, bukan seluruh baris.

                  w-fit membuat lebar tautan mengikuti panjang teksnya saja,
                  tidak melebar mengisi kolom.

                  py-2 -my-2 menambah tinggi area sentuh menjadi sekitar 44px
                  tanpa mengubah jarak antar baris. Di HP, area setinggi teks
                  saja terlalu tipis untuk disentuh jari dengan nyaman. */}
              <a
                href={item.href}
                target={isExternal ? '_blank' : undefined}
                /* noreferrer melindungi dari halaman tujuan yang bisa
                   mengintip atau mengubah tab asal lewat window.opener. */
                rel={isExternal ? 'noreferrer' : undefined}
                className="group -my-2 inline-flex w-fit items-center gap-3 py-2 font-display text-xl font-bold text-heading transition-colors duration-200 hover:text-accent motion-reduce:transition-none"
              >
                {item.value}
                <span
                  aria-hidden="true"
                  className="transition-transform duration-200 ease-out-expo group-hover:translate-x-1 motion-reduce:transition-none"
                >
                  &rarr;
                </span>
              </a>
            </li>
          )
        })}
      </ul>
    </Section>
  )
}

export default Contact
