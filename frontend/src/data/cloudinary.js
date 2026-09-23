/*
  Alamat gambar Cloudinary dengan ukuran tertentu.

  Gambar aslinya bisa ratusan KB. Dengan menyisipkan instruksi setelah
  "/upload/" di alamatnya, Cloudinary mengirim versi yang sudah dikecilkan:
    w_640,h_320 : ukuran yang diminta
    c_pad       : seluruh gambar dimuat; sisanya diberi latar (lihat fit)
    f_auto      : format paling ringan yang didukung browser (biasanya WebP/AVIF)
    q_auto      : kualitas diatur otomatis
  Gambar 150 KB biasanya jadi belasan KB.

*/
export function cloudinaryImage(url, width, height, { fit = 'pad' } = {}) {
  /*
    fit 'pad'  : seluruh gambar terlihat. Kalau bentuknya tidak pas, sisanya
                 diisi warna yang diambil otomatis dari gambar itu sendiri
                 (b_auto), jadi menyatu dengan kartu tanpa menulis kode warna.
                 Dipakai untuk tangkapan layar project — memotongnya berarti
                 membuang bagian yang justru ingin ditunjukkan.
    fit 'fill' : dipotong sampai mengisi penuh. Untuk gambar yang bagian
                 pinggirnya tidak penting.
  */
  const crop = fit === 'pad' ? 'c_pad,b_auto' : 'c_fill'

  const transform = [`w_${width}`, height && `h_${height}`, crop, 'f_auto', 'q_auto']
    .filter(Boolean)
    .join(',')

  return url.replace('/upload/', `/upload/${transform}/`)
}
