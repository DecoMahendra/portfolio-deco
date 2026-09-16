<x-field name="school" label="Sekolah / kampus" :value="$education?->school" required />
<x-field name="program" label="Program / jurusan" :value="$education?->program" required />
<x-field name="period" label="Periode" :value="$education?->period" placeholder="Contoh: 2023 — Sekarang" required />
{{-- Posisi mulai dari 1 (di database sort_order mulai dari 0, konversinya di trait HasSortOrder). --}}
<x-field name="position" label="Urutan tampil (1 = paling atas)" type="number" :value="$education ? $education->sort_order + 1 : $nextPosition" min="1" required />
