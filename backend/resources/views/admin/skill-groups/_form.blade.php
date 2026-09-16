<x-field name="name" label="Nama kelompok" :value="$group?->name" placeholder="Contoh: Pengembangan Web" required />
{{-- Posisi mulai dari 1 (di database sort_order mulai dari 0, konversinya di trait HasSortOrder). --}}
<x-field name="position" label="Urutan tampil (1 = paling atas)" type="number" :value="$group ? $group->sort_order + 1 : $nextPosition" min="1" required />
