<x-field name="school" label="Sekolah / kampus" :value="$education?->school" required />
<x-field name="program" label="Program / jurusan" :value="$education?->program" required />
<x-field name="period" label="Periode" :value="$education?->period" placeholder="Contoh: 2023 — Sekarang" required />
<x-field name="sort_order" label="Urutan tampil (0 = paling atas)" type="number" :value="$education?->sort_order ?? 0" min="0" required />
