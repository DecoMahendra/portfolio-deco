#!/bin/sh
# Dijalankan setiap kali aplikasi dinyalakan di server (lihat CMD di Dockerfile).
# set -e: kalau ada perintah yang gagal, berhenti — jangan diam-diam lanjut.
set -e

# Menerapkan perubahan struktur tabel ke database online.
# --force: jalan tanpa bertanya, karena di server tidak ada yang bisa menjawab.
php artisan migrate --force

# Menyatukan pengaturan, route, dan tampilan jadi berkas siap pakai supaya
# lebih cepat. Dilakukan saat start, bukan saat membangun paket, karena
# nilai environment variable baru tersedia sekarang.
php artisan config:cache
php artisan route:cache
php artisan view:cache

# ${PORT:-8000}: pakai PORT dari hosting; kalau tidak ada, pakai 8000.
# --host=0.0.0.0 supaya bisa dihubungi dari luar paket, bukan cuma dari dalam.
php artisan serve --host=0.0.0.0 --port="${PORT:-8000}"
