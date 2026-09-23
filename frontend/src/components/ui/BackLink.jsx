import { Link, useLocation, useNavigate } from 'react-router'

/*
  BackLink — tombol kembali ke halaman sebelumnya.

  Dua keadaan yang harus dibedakan:

  1. Pengunjung sampai ke sini dengan menjelajah website ini (misalnya dari
     beranda lalu mengklik kartu project). Kembali = mundur satu langkah,
     jadi dia kembali persis ke tempat dia tadi, termasuk posisi gulirnya.

  2. Pengunjung membuka alamat ini langsung — dari link yang dibagikan,
     hasil pencarian, atau bookmark. Tidak ada halaman sebelumnya di website
     ini; mundur akan melemparnya keluar. Jadi ditampilkan tautan biasa ke
     halaman yang masuk akal (fallbackTo).

  Cara membedakannya: React Router memberi tanda 'default' pada alamat yang
  jadi titik masuk pertama. Kalau tandanya masih 'default', berarti belum ada
  perpindahan halaman di dalam website ini.

  fallbackTo    : alamat tujuan kalau tidak ada halaman sebelumnya
  fallbackLabel : tulisannya untuk keadaan itu
*/
const STYLE =
  'group inline-flex items-center gap-2 text-sm font-semibold text-faint transition-colors hover:text-heading motion-reduce:transition-none'

function BackLink({ fallbackTo, fallbackLabel }) {
  const navigate = useNavigate()
  const canGoBack = useLocation().key !== 'default'

  const arrow = (
    <span
      aria-hidden="true"
      className="transition-transform duration-200 ease-out-expo group-hover:-translate-x-1 motion-reduce:transition-none"
    >
      &larr;
    </span>
  )

  // Mundur itu sebuah tindakan, bukan berpindah ke alamat tertentu,
  // jadi dipakai <button>, bukan <a>.
  if (canGoBack) {
    return (
      <button type="button" onClick={() => navigate(-1)} className={STYLE}>
        {arrow}
        Kembali
      </button>
    )
  }

  return (
    <Link to={fallbackTo} className={STYLE}>
      {arrow}
      {fallbackLabel}
    </Link>
  )
}

export default BackLink
