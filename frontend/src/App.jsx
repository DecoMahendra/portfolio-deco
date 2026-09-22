import { BrowserRouter, Route, Routes } from 'react-router'
import Layout from './components/layout/Layout'
import HomePage from './pages/HomePage'
import NotFoundPage from './pages/NotFoundPage'

/*
  App — daftar alamat website dan halaman untuk masing-masing.

  Semua halaman dibungkus Layout (navbar + footer), jadi Route anak di
  dalamnya cukup menyebut isi halamannya saja.

  - index : alamat "/" (beranda)
  - "*"   : alamat apa pun yang tidak cocok dengan yang di atasnya -> 404

  Halaman project dan sertifikat ditambahkan di tahap Media & Galeri.
*/
function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route element={<Layout />}>
          <Route index element={<HomePage />} />
          <Route path="*" element={<NotFoundPage />} />
        </Route>
      </Routes>
    </BrowserRouter>
  )
}

export default App
