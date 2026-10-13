{{--
  Kotak unggah tarik-lepas (drag & drop). Dipakai untuk gambar project dan sertifikat.

  Cara kerjanya: input file asli tetap ada tapi disembunyikan (sr-only —
  tidak terlihat, tapi masih bisa difokus keyboard). Seluruh kotak adalah
  <label> untuk input itu, jadi klik di mana pun membuka pemilih file.
  Tarik-lepas dan pratinjau ditangani app.js lewat data-dropzone / data-preview.

  crop: setelah gambar dipilih, muncul jendela untuk memotongnya jadi persegi
  (sama bentuknya dengan foto di "Tentang saya") sebelum dipakai. Yang
  diunggah adalah hasil potongannya, bukan gambar aslinya.
--}}
@props(['name', 'id', 'multiple' => false, 'crop' => false, 'label' => 'Tarik gambar ke sini atau klik untuk memilih'])

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
            @if ($crop) data-crop="{{ $id }}-crop" @endif
            class="sr-only"
        >
    </label>

    @if ($crop)
        {{--
          Jendela potong. Ada di DALAM form, jadi semua tombolnya type="button"
          supaya tidak ikut mengirim form. Logikanya di resources/js/app.js.

          touch-none: geseran jari di kotak potong menggeser foto, bukan halaman.
        --}}
        <dialog id="{{ $id }}-crop" class="m-auto w-[calc(100%-3rem)] max-w-sm rounded-lg border border-line bg-raised p-6 text-body backdrop:bg-page/80">
            <h2 class="font-semibold text-heading">Atur foto</h2>
            <p class="mt-1 text-sm text-faint">Geser untuk mengatur posisi, perbesar dengan penggeser di bawah. Bentuk kotak ini sama dengan foto di "Tentang saya".</p>

            <div
                data-crop-frame tabindex="0"
                aria-label="Area potong. Tombol panah untuk menggeser, plus dan minus untuk memperbesar."
                class="relative mt-4 aspect-square w-full cursor-grab touch-none overflow-hidden rounded-lg border border-line bg-page active:cursor-grabbing"
            >
                <img data-crop-image alt="" draggable="false" class="absolute left-0 top-0 max-w-none origin-top-left select-none">
            </div>

            <label class="mt-4 block text-sm">
                Perbesar
                <input type="range" data-crop-zoom min="1" max="4" step="0.01" value="1" class="mt-2 block w-full accent-accent">
            </label>

            <div class="mt-6 flex items-center justify-end gap-6">
                <button type="button" data-crop-cancel class="inline-flex min-h-11 items-center px-2 -mx-2 text-sm text-faint hover:text-heading">Batal</button>
                <x-button type="button" data-crop-confirm>Pakai foto ini</x-button>
            </div>
        </dialog>
    @endif

    {{-- name "new_images[]" -> kunci error "new_images.*"; name "image" -> "image". --}}
    @php($errorKey = rtrim($name, '[]').($multiple ? '.*' : ''))
    @error($errorKey)
        <p class="mt-1.5 text-sm text-danger">{{ $message }}</p>
    @enderror
</div>
