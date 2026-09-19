#!/bin/sh
# Dijalankan setiap kali aplikasi dinyalakan di server (lihat CMD di Dockerfile).
# set -e: kalau ada perintah yang gagal, berhenti — jangan diam-diam lanjut.
set -e

# Sertifikat koneksi database tidak ikut masuk ke dalam paket (berkas rahasia).
# Di server, isinya dikirim lewat environment variable lalu ditulis jadi berkas.
#
# Ada dua bentuk karena sebagian layanan hosting hanya menerima nilai satu baris,
# sedangkan sertifikat aslinya beberapa baris:
#   DB_SSL_CA_B64 : sertifikat dalam bentuk base64 (satu baris) — dipakai duluan
#   DB_SSL_CA     : sertifikat apa adanya (beberapa baris)
# export: supaya terbaca oleh perintah php di bawahnya.
if [ -n "$DB_SSL_CA_B64" ]; then
    mkdir -p storage/certs
    echo "$DB_SSL_CA_B64" | base64 -d > storage/certs/ca.pem
    export MYSQL_ATTR_SSL_CA=storage/certs/ca.pem
elif [ -n "$DB_SSL_CA" ]; then
    mkdir -p storage/certs
    printf '%s' "$DB_SSL_CA" > storage/certs/ca.pem
    export MYSQL_ATTR_SSL_CA=storage/certs/ca.pem
fi

# Menerapkan perubahan struktur tabel ke database online.
# --force: jalan tanpa bertanya, karena di server tidak ada yang bisa menjawab.
php artisan migrate --force

# Menyatukan pengaturan, route, dan tampilan jadi berkas siap pakai supaya
# lebih cepat. Dilakukan saat start, bukan saat membangun paket, karena
# nilai environment variable baru tersedia sekarang.
php artisan config:cache
php artisan route:cache
php artisan view:cache

# ${PORT:-8000}: pakai PORT dari Render; kalau tidak ada (uji di komputer sendiri), pakai 8000.
# --host=0.0.0.0 supaya bisa dihubungi dari luar paket, bukan cuma dari dalam.
php artisan serve --host=0.0.0.0 --port="${PORT:-8000}"
