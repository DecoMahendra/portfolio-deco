<x-field name="name" label="Nama project" :value="$project?->name" required />
<x-field name="slug" label="Alamat (slug) — kosongkan untuk dibuat otomatis dari nama" :value="$project?->slug" placeholder="website-portfolio-pribadi" />
<x-field name="description" label="Deskripsi" :value="$project?->description" rows="5" required />
{{-- tech di database berupa array; di form ditampilkan sebagai teks dipisah koma. --}}
<x-field name="tech" label="Teknologi (pisahkan dengan koma)" :value="implode(', ', $project?->tech ?? [])" placeholder="React, Vite, Tailwind CSS" required />
<x-field name="repo_url" label="URL repository (boleh kosong)" type="url" :value="$project?->repo_url" placeholder="https://github.com/..." />
<x-field name="demo_url" label="URL demo (boleh kosong)" type="url" :value="$project?->demo_url" placeholder="https://..." />
{{-- Posisi mulai dari 1 (di database sort_order mulai dari 0, konversinya di trait HasSortOrder). --}}
<x-field name="position" label="Urutan tampil (1 = paling atas)" type="number" :value="$project ? $project->sort_order + 1 : $nextPosition" min="1" required />
