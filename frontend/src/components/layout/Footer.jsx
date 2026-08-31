import Container from '../ui/Container'
import { PROFILE } from '../../data/profile'

/*
  Footer — penutup halaman.

  Sengaja tidak mengulang tautan email dan media sosial. Letaknya persis di
  bawah section Contact yang isinya sudah itu — mengulang cuma menambah
  panjang tanpa menambah guna.

  Tahunnya dihitung langsung saat halaman dirender, jadi tidak perlu diperbarui
  manual tiap ganti tahun.
*/
function Footer() {
  const year = new Date().getFullYear()

  return (
    <footer className="border-t border-line-soft py-10">
      <Container>
        <div className="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
          <p className="text-sm text-faint">
            &copy; {year} {PROFILE.name}
          </p>

          <p className="font-mono text-eyebrow uppercase tracking-[0.18em] text-faint">
            Dibangun dengan Sepenuh Hati oleh Developer
          </p>
        </div>
      </Container>
    </footer>
  )
}

export default Footer
