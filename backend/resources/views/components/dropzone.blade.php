{{--
  Kotak unggah tarik-lepas (drag & drop). Dipakai untuk gambar project dan sertifikat.

  Cara kerjanya: input file asli tetap ada tapi disembunyikan (sr-only —
  tidak terlihat, tapi masih bisa difokus keyboard). Seluruh kotak adalah
  <label> untuk input itu, jadi klik di mana pun membuka pemilih file.
  Tarik-lepas dan pratinjau ditangani app.js lewat data-dropzone / data-preview.
--}}
@props(['name', 'id', 'multiple' => false, 'label' => 'Tarik gambar ke sini atau klik untuk memilih'])

<div>
    <label
        for="{{ $id }}" data-dropzone
        class="flex cursor-pointer flex-col items-center gap-2 rounded-lg border-2 border-dashed border-line bg-surface px-6 py-8 text-center text-sm transition-colors hover:border-faint has-[:focus-visible]:border-accent data-dragging:border-accent data-dragging:bg-raised"
    >
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="text-faint">
            <path d="M12 16V4m0 0-4 4m4-4 4 4M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2" />
        </svg>
        {{-- Setelah file dipilih, pratinjau tampil di sini dan kotak mengikuti ukurannya (app.js). --}}
        {{-- items-start: tiap gambar setinggi aslinya, tidak diregangkan mengikuti gambar tertinggi di barisnya. --}}
        <div id="{{ $id }}-preview" class="flex w-full flex-wrap items-start justify-center gap-3 empty:hidden"></div>

        <span class="text-heading" data-dropzone-label data-label-empty="{{ $label }}" data-label-filled="Klik atau tarik lagi untuk mengganti">{{ $label }}</span>
        <span class="text-faint">{{ $multiple ? 'Bisa beberapa sekaligus · ' : '' }}jpg/png/webp · maks 5 MB{{ $multiple ? ' per file' : '' }}</span>

        <input
            type="file" id="{{ $id }}" name="{{ $name }}" accept="image/jpeg,image/png,image/webp"
            @if ($multiple) multiple @endif data-preview="{{ $id }}-preview"
            class="sr-only"
        >
    </label>

    {{-- name "new_images[]" -> kunci error "new_images.*"; name "image" -> "image". --}}
    @php($errorKey = rtrim($name, '[]').($multiple ? '.*' : ''))
    @error($errorKey)
        <p class="mt-1.5 text-sm text-danger">{{ $message }}</p>
    @enderror
</div>
