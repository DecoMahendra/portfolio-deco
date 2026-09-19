# Dockerfile = resep membangun "paket" berisi aplikasi + PHP + semua kebutuhannya,
# supaya jalan sama persis di komputer sendiri maupun di server Render.
#
# Dibangun bertahap (multi-stage): tahap composer dan node hanya dipakai untuk
# menyiapkan berkas, lalu dibuang. Hasil akhirnya cuma tahap terakhir, jadi
# Composer dan Node.js tidak ikut terbawa ke server — paketnya jauh lebih ramping.

# ---------- Tahap 1: paket PHP ----------
FROM composer:2 AS vendor

WORKDIR /app

# Salin berkas daftar paket dulu, baru jalankan install. Selama kedua berkas ini
# tidak berubah, Docker memakai hasil sebelumnya — membangun ulang jadi cepat.
COPY composer.json composer.lock ./

# --no-dev: paket untuk pengembangan (Pint, PHPUnit) tidak perlu di server.
# --no-scripts: perintah artisan belum bisa jalan, kodenya belum disalin.
RUN composer install --no-dev --no-scripts --no-interaction --prefer-dist

# ---------- Tahap 2: CSS & JS dashboard ----------
FROM node:24-alpine AS assets

WORKDIR /app

COPY package.json package-lock.json ./
# npm ci: install persis sesuai package-lock.json, tidak menaikkan versi diam-diam.
RUN npm ci

# Tailwind memindai berkas Blade untuk tahu class mana yang dipakai,
# jadi resources/ dan vendor/ ikut disalin (app.css menunjuk ke keduanya).
COPY vite.config.js ./
COPY resources ./resources
COPY --from=vendor /app/vendor ./vendor
RUN mkdir -p storage/framework/views

RUN npm run build

# ---------- Tahap 3: hasil akhir ----------
FROM php:8.3-cli-alpine

# pdo_mysql: agar Laravel bisa bicara dengan database MySQL.
RUN docker-php-ext-install pdo_mysql

WORKDIR /app

COPY . .
COPY --from=vendor /app/vendor ./vendor
COPY --from=assets /app/public/build ./public/build

# Autoload Composer perlu dibuat ulang setelah kode disalin (tadi --no-scripts).
COPY --from=vendor /usr/bin/composer /usr/bin/composer

# Folder kerja Laravel dibuat eksplisit: isinya dibuang oleh .dockerignore, dan
# sebagian pembangun Docker (misalnya kaniko yang dipakai Back4app) tidak ikut
# membuat folder kosong. Tanpa ini "php artisan view:cache" gagal dengan
# "View path not found" — dan itu baru ketahuan di server, bukan di komputer sendiri.
RUN mkdir -p storage/framework/views storage/framework/cache/data \
        storage/framework/sessions storage/logs bootstrap/cache \
    && composer dump-autoload --no-dev --optimize \
    && chmod -R ug+w storage bootstrap/cache \
    && chmod +x docker-start.sh

# Render memberi tahu port yang harus didengarkan lewat variabel PORT.
EXPOSE 8000

CMD ["./docker-start.sh"]
