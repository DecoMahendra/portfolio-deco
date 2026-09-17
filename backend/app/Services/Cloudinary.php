<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;

/*
  Jembatan ke Cloudinary — layanan penyimpanan gambar.

  Cloudinary punya API HTTP biasa, jadi cukup HTTP client bawaan Laravel,
  tanpa library tambahan. Tiap permintaan harus "ditandatangani": parameter
  diurutkan, digabung, ditambah API secret, lalu di-hash SHA-1. Cloudinary
  menghitung hal yang sama di sisinya; kalau cocok, permintaan diterima.
  Itulah kenapa API secret tidak boleh bocor — siapa pun yang punya bisa
  mengunggah/menghapus atas nama kita.

  Hasil upload yang dipakai: secure_url (untuk ditampilkan) dan public_id
  (untuk menghapus nanti).
*/
class Cloudinary
{
    private string $cloudName;

    private string $apiKey;

    private string $apiSecret;

    public function __construct()
    {
        $this->cloudName = config('services.cloudinary.cloud_name');
        $this->apiKey = config('services.cloudinary.api_key');
        $this->apiSecret = config('services.cloudinary.api_secret');
    }

    /** @return array{url: string, public_id: string} */
    public function upload(UploadedFile $file, string $folder): array
    {
        $params = ['folder' => $folder, 'timestamp' => (string) time()];

        $response = Http::attach('file', $file->get(), $file->getClientOriginalName())
            ->post($this->endpoint('upload'), $this->signed($params))
            ->throw()
            ->json();

        return ['url' => $response['secure_url'], 'public_id' => $response['public_id']];
    }

    public function delete(string $publicId): void
    {
        $params = ['public_id' => $publicId, 'timestamp' => (string) time()];

        // Kalau gambarnya sudah tidak ada di Cloudinary, jawabannya "not found",
        // bukan error — tidak masalah, tujuannya memang supaya tidak ada.
        Http::post($this->endpoint('destroy'), $this->signed($params))->throw();
    }

    /*
      Alamat gambar dengan ukuran & format diatur oleh Cloudinary.
      Caranya: sisipkan instruksi setelah "/upload/" di URL, misalnya
      .../upload/w_400,h_300,c_fill,f_auto,q_auto/... → lebar 400, tinggi 300,
      dipotong pas (c_fill), format & kualitas otomatis (WebP kalau didukung).
      Gambar aslinya tidak berubah; Cloudinary membuat versi kecilnya saat diminta.
    */
    public static function resized(string $url, int $width, ?int $height = null): string
    {
        $transform = "w_{$width},c_fill,f_auto,q_auto".($height ? ",h_{$height}" : '');

        return str_replace('/upload/', "/upload/{$transform}/", $url);
    }

    private function endpoint(string $action): string
    {
        return "https://api.cloudinary.com/v1_1/{$this->cloudName}/image/{$action}";
    }

    // Tambahkan api_key + signature ke parameter, sesuai aturan Cloudinary.
    private function signed(array $params): array
    {
        ksort($params);

        $toSign = http_build_query($params, '', '&', PHP_QUERY_RFC3986);
        $toSign = urldecode($toSign);

        return $params + [
            'api_key' => $this->apiKey,
            'signature' => sha1($toSign.$this->apiSecret),
        ];
    }
}
