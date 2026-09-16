<x-field name="name" label="Nama sertifikat / kegiatan" :value="$certificate?->name" required />
<x-field name="organizer" label="Penyelenggara" :value="$certificate?->organizer" required />
<x-field name="year" label="Tahun" :value="$certificate?->year" placeholder="Contoh: 2024, 2025" required />
{{-- Posisi mulai dari 1 (di database sort_order mulai dari 0, konversinya di trait HasSortOrder). --}}
<x-field name="position" label="Urutan tampil (1 = paling atas)" type="number" :value="$certificate ? $certificate->sort_order + 1 : $nextPosition" min="1" required />
