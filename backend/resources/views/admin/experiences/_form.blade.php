{{--
  Field yang sama dipakai form tambah dan form ubah, jadi ditaruh di satu
  file. Awalan "_" penanda: ini potongan, bukan halaman utuh.
  $experience boleh null (saat tambah) — "?->" mengembalikan null alih-alih error.
--}}
<x-field name="role" label="Peran" :value="$experience?->role" required />
<x-field name="company" label="Tempat / organisasi" :value="$experience?->company" required />
<x-field name="period" label="Periode" :value="$experience?->period" placeholder="Contoh: Juli 2026 — Sekarang" required />
<x-field name="description" label="Deskripsi" :value="$experience?->description" rows="5" required />
{{-- Posisi mulai dari 1 (di database sort_order mulai dari 0, konversinya di trait HasSortOrder). --}}
<x-field name="position" label="Urutan tampil (1 = paling atas)" type="number" :value="$experience ? $experience->sort_order + 1 : $nextPosition" min="1" required />
