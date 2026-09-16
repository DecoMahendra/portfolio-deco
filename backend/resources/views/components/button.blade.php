{{-- Tombol utama (warna aksen). {{ $slot }} = isi di antara tag pembuka dan penutup. --}}
<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'rounded-md bg-accent px-4 py-2.5 font-semibold text-page hover:bg-accent-deep']) }}
>
    {{ $slot }}
</button>
