import { BrowserRouter, Route, Routes } from 'react-router'
import Layout from './components/layout/Layout'
import CertificatesPage from './pages/CertificatesPage'
import HomePage from './pages/HomePage'
import NotFoundPage from './pages/NotFoundPage'
import ProjectDetailPage from './pages/ProjectDetailPage'
import ProjectsPage from './pages/ProjectsPage'

/*
  App — daftar alamat website dan halaman untuk masing-masing.

  Semua halaman dibungkus Layout (navbar + footer), jadi Route anak di
  dalamnya cukup menyebut isi halamannya saja.

  - index            : alamat "/" (beranda)
  - "projects"       : daftar semua project
  - "projects/:slug" : satu project. ":slug" berarti bagian itu berubah-ubah,
                       nilainya dibaca halamannya lewat useParams.
  - "certificates"   : daftar pelatihan & sertifikasi
  - "*"              : alamat apa pun yang tidak cocok di atasnya -> 404
*/
function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route element={<Layout />}>
          <Route index element={<HomePage />} />
          <Route path="projects" element={<ProjectsPage />} />
          <Route path="projects/:slug" element={<ProjectDetailPage />} />
          <Route path="certificates" element={<CertificatesPage />} />
          <Route path="*" element={<NotFoundPage />} />
        </Route>
      </Routes>
    </BrowserRouter>
  )
}

export default App
