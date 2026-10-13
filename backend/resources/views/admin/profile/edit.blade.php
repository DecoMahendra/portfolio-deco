@extends('layouts.admin')

@section('title', 'Profil')

@section('content')
    <h1 class="mb-8 text-2xl font-semibold text-heading">Profil</h1>

    {{--
      Form HTML hanya mengenal GET dan POST. @method('PUT') menyisipkan
      field tersembunyi supaya Laravel memperlakukannya sebagai PUT,
      sesuai route admin.profile.update.

      enctype="multipart/form-data": wajib untuk form yang mengirim file.
      Tanpa ini browser hanya mengirim NAMA file-nya, bukan isinya.
    --}}
    <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="max-w-2xl space-y-5">
        @csrf
        @method('PUT')

        <x-field name="name" label="Nama" :value="$profile->name" required />
        <x-field name="role" label="Peran" :value="$profile->role" required />
        <x-field name="location" label="Lokasi" :value="$profile->location" required />
        <x-field name="availability" label="Ketersediaan" :value="$profile->availability" required />
        <x-field name="tagline" label="Tagline" :value="$profile->tagline" rows="2" required />
        <x-field name="bio" label="Bio (pisahkan paragraf dengan baris kosong)" :value="$profile->bio" rows="6" required />
        {{--
          Foto "Tentang saya" — satu-satunya cara menambahkannya. Opsional:
          selama belum diunggah, website menampilkan ikon pengganti.
        --}}
        <div>
            <p class="mb-1.5 text-sm">Foto</p>
            @if ($profile->photo_url)
                <img
                    src="{{ App\Services\Cloudinary::resized($profile->photo_url, 240, 240) }}"
                    alt="" width="240" height="240"
                    class="mb-3 size-40 rounded-md object-cover"
                >
            @else
                <p class="mb-3 text-sm text-faint">Belum ada foto — website menampilkan ikon pengganti.</p>
            @endif

            <x-dropzone name="photo" id="photo" crop :label="$profile->photo_url ? 'Tarik foto pengganti ke sini atau klik untuk memilih' : 'Tarik foto ke sini atau klik untuk memilih'" />
            <p class="mt-1.5 text-sm text-faint">Setelah memilih foto, Anda bisa mengatur bagian yang ditampilkan.</p>
        </div>

        <x-field name="photo_alt" label="Teks alternatif foto" :value="$profile->photo_alt" required />

        <x-button>Simpan</x-button>
    </form>
@endsection
