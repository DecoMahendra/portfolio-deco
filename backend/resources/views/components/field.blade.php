{{--
  Komponen Blade = potongan tampilan yang bisa dipakai ulang, mirip component
  di React. Dipanggil sebagai <x-field name="..." label="..." />.

  Satu field = label + input (atau textarea kalau diberi rows) + pesan error.
  old($name, $value): kalau form ditolak validasi, isi yang tadi diketik
  dikembalikan supaya tidak hilang; kalau tidak, pakai nilai dari database.
--}}
@props(['name', 'label', 'value' => '', 'type' => 'text', 'rows' => null, 'id' => null])

{{-- id bawaan = name. Diganti kalau field yang sama muncul berulang di satu halaman (id harus unik). --}}
@php($id ??= $name)

<div>
    <label for="{{ $id }}" class="mb-1.5 block text-sm">{{ $label }}</label>

    @if ($rows)
        <textarea
            id="{{ $id }}" name="{{ $name }}" rows="{{ $rows }}"
            {{ $attributes->merge(['class' => 'w-full rounded-md border border-line bg-surface px-3 py-2 text-heading']) }}
        >{{ old($name, $value) }}</textarea>
    @else
        <input
            type="{{ $type }}" id="{{ $id }}" name="{{ $name }}" value="{{ old($name, $value) }}"
            {{ $attributes->merge(['class' => 'w-full rounded-md border border-line bg-surface px-3 py-2 text-heading']) }}
        >
    @endif

    @error($name)
        <p class="mt-1.5 text-sm text-danger">{{ $message }}</p>
    @enderror
</div>
