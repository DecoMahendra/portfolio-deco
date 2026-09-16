{{--
  Kelompok tidak bisa diganti: ditampilkan sebagai teks saja.
  Saat tambah, id kelompok dikirim lewat input hidden (server tetap
  memeriksa id-nya ada). Saat ubah, kelompok tidak dikirim sama sekali —
  controller memakai kelompok skill yang sekarang.
--}}
<div>
    <p class="mb-1.5 text-sm">Kelompok</p>
    <p class="rounded-md border border-line bg-raised px-3 py-2 text-heading">{{ $group->name }}</p>
    @if (! $skill)
        <input type="hidden" name="skill_group_id" value="{{ $group->id }}">
    @endif
    @error('skill_group_id')
        <p class="mt-1.5 text-sm text-danger">{{ $message }}</p>
    @enderror
</div>

<x-field name="name" label="Nama skill" :value="$skill?->name" placeholder="Contoh: React" required />
{{-- Posisi mulai dari 1 (di database sort_order mulai dari 0, konversinya di trait HasSortOrder). --}}
<x-field name="position" label="Urutan tampil di kelompoknya (1 = paling awal)" type="number" :value="$skill ? $skill->sort_order + 1 : $nextPosition" min="1" required />
