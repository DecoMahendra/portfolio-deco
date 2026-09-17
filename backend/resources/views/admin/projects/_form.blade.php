<x-field name="name" label="Nama project" :value="$project?->name" required />
<x-field name="slug" label="Alamat (slug) — kosongkan untuk dibuat otomatis dari nama" :value="$project?->slug" placeholder="website-portfolio-pribadi" />
<x-field name="description" label="Deskripsi" :value="$project?->description" rows="5" required />
{{-- tech di database berupa array; di form ditampilkan sebagai teks dipisah koma. --}}
<x-field name="tech" label="Teknologi (pisahkan dengan koma)" :value="implode(', ', $project?->tech ?? [])" placeholder="React, Vite, Tailwind CSS" required />
<x-field name="repo_url" label="URL repository (boleh kosong)" type="url" :value="$project?->repo_url" placeholder="https://github.com/..." />
<x-field name="demo_url" label="URL demo (boleh kosong)" type="url" :value="$project?->demo_url" placeholder="https://..." />
{{-- Posisi mulai dari 1 (di database sort_order mulai dari 0, konversinya di trait HasSortOrder). --}}
<x-field name="position" label="Urutan tampil (1 = paling atas)" type="number" :value="$project ? $project->sort_order + 1 : $nextPosition" min="1" required />

<fieldset class="space-y-4">
    <legend class="mb-1 text-sm font-semibold text-heading">Gambar</legend>
    <p class="text-sm text-faint">Slide di halaman detail project. Gambar urutan 1 jadi sampul. Semua tersimpan saat menekan Simpan.</p>

    {{--
      Gambar yang sudah ada (hanya saat ubah). Nama input berbentuk array
      images_meta[<id>][alt] supaya controller tahu gambar mana yang dimaksud.
      Tombol Hapus menunjuk form lain lewat atribut form="..." — form hapusnya
      ada di edit.blade.php, di luar form ini, karena form tidak bisa bersarang.
    --}}
    @foreach ($project?->images ?? [] as $image)
        <div class="flex gap-4 rounded-lg border border-line bg-surface p-4">
            <img
                src="{{ App\Services\Cloudinary::resized($image->url, 160, 100) }}"
                alt="{{ $image->alt ?? '' }}" width="160" height="100"
                class="h-25 w-40 shrink-0 rounded-md object-cover"
            >
            <div class="flex grow flex-col gap-3">
                <div>
                    <label for="alt-{{ $image->id }}" class="mb-1.5 block text-sm">Teks alternatif (boleh kosong)</label>
                    <input type="text" id="alt-{{ $image->id }}" name="images_meta[{{ $image->id }}][alt]" value="{{ $image->alt }}"
                           class="w-full rounded-md border border-line bg-surface px-3 py-2 text-heading">
                </div>
                <div class="flex items-end gap-4">
                    <div class="w-28">
                        <label for="position-{{ $image->id }}" class="mb-1.5 block text-sm">Urutan</label>
                        <input type="number" id="position-{{ $image->id }}" name="images_meta[{{ $image->id }}][position]" value="{{ $image->sort_order + 1 }}" min="1" required
                               class="w-full rounded-md border border-line bg-surface px-3 py-2 text-heading">
                    </div>
                    <button type="submit" form="delete-image-{{ $image->id }}" class="pb-2 text-sm text-danger hover:underline">Hapus</button>
                </div>
            </div>
        </div>
    @endforeach

    <x-dropzone name="new_images[]" id="new_images" :multiple="true" label="Tarik gambar ke sini atau klik untuk memilih" />
</fieldset>
