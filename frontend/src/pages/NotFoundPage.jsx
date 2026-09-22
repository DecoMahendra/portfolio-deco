import { Link } from 'react-router'
import Container from '../components/ui/Container'

/*
  NotFoundPage — ditampilkan untuk alamat yang tidak dikenal.

  Sebelumnya alamat ngawur menampilkan halaman error bawaan Vercel yang
  tampilannya asing. Sekarang tetap bergaya website ini, dan ada jalan pulang.

  <title> dan <meta> di bawah otomatis dipindahkan React ke <head>.
  noindex: supaya halaman ini tidak masuk hasil pencarian Google.
*/
function NotFoundPage() {
  return (
    <>
      <title>Halaman tidak ditemukan — Deco Mahendra</title>
      <meta name="robots" content="noindex" />

      <Container>
        <div className="flex min-h-svh flex-col items-start justify-center pt-28 pb-20">
          <p className="font-mono text-eyebrow uppercase tracking-[0.22em] text-accent">
            404
          </p>
          <h1 className="mt-5 font-display text-4xl font-bold tracking-tight text-heading md:text-6xl">
            Halaman tidak ditemukan
          </h1>
          <p className="mt-5 max-w-md text-lg leading-relaxed text-body">
            Alamat yang dibuka tidak ada, atau sudah dipindahkan.
          </p>
          <Link
            to="/"
            className="mt-10 inline-flex items-center justify-center gap-2 rounded-full bg-accent px-7 py-3.5 font-display font-bold text-page transition-colors duration-200 hover:bg-accent-deep motion-reduce:transition-none"
          >
            Kembali ke beranda
          </Link>
        </div>
      </Container>
    </>
  )
}

export default NotFoundPage
