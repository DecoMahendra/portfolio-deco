<x-field name="name" label="Nama project" :value="$project?->name" required />
<x-field name="description" label="Deskripsi" :value="$project?->description" rows="5" required />
{{-- tech di database berupa array; di form ditampilkan sebagai teks dipisah koma. --}}
<x-field name="tech" label="Teknologi (pisahkan dengan koma)" :value="implode(', ', $project?->tech ?? [])" placeholder="React, Vite, Tailwind CSS" required />
<x-field name="repo_url" label="URL repository (boleh kosong)" type="url" :value="$project?->repo_url" placeholder="https://github.com/..." />
<x-field name="demo_url" label="URL demo (boleh kosong)" type="url" :value="$project?->demo_url" placeholder="https://..." />
<x-field name="sort_order" label="Urutan tampil (0 = paling atas)" type="number" :value="$project?->sort_order ?? 0" min="0" required />
