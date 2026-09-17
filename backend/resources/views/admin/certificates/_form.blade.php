<x-field name="name" label="Nama sertifikat / kegiatan" :value="$certificate?->name" required />
<x-field name="organizer" label="Penyelenggara" :value="$certificate?->organizer" required />
<x-field name="year" label="Tahun" :value="$certificate?->year" placeholder="Contoh: 2024, 2025" required />
{{-- Gambar opsional. Disimpan di Cloudinary; di sini hanya pratinjau + pilih file. --}}
<div>
    @if ($certificate?->image_url)
        <img
            src="{{ App\Services\Cloudinary::resized($certificate->image_url, 320, 220) }}"
            alt="" width="320" height="220"
            class="mb-3 h-55 w-80 max-w-full rounded-md object-cover"
        >
        <label class="mb-3 flex items-center gap-2 text-sm">
            <input type="checkbox" name="remove_image" value="1" class="size-4 accent-danger">
            Hapus gambar ini
        </label>
    @endif

    <x-dropzone name="image" id="image" :label="$certificate?->image_url ? 'Tarik gambar pengganti ke sini atau klik untuk memilih' : 'Tarik gambar ke sini atau klik untuk memilih'" />
</div>
{{-- Posisi mulai dari 1 (di database sort_order mulai dari 0, konversinya di trait HasSortOrder). --}}
<x-field name="position" label="Urutan tampil (1 = paling atas)" type="number" :value="$certificate ? $certificate->sort_order + 1 : $nextPosition" min="1" required />
