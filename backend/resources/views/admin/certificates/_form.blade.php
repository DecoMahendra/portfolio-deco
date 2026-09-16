<x-field name="name" label="Nama sertifikat / kegiatan" :value="$certificate?->name" required />
<x-field name="organizer" label="Penyelenggara" :value="$certificate?->organizer" required />
<x-field name="year" label="Tahun" :value="$certificate?->year" placeholder="Contoh: 2024, 2025" required />
<x-field name="sort_order" label="Urutan tampil (0 = paling atas)" type="number" :value="$certificate?->sort_order ?? 0" min="0" required />
