@extends('layouts.admin')

@section('title', 'Profil')

@section('content')
    <h1 class="mb-8 text-2xl font-semibold text-heading">Profil</h1>

    {{--
      Form HTML hanya mengenal GET dan POST. @method('PUT') menyisipkan
      field tersembunyi supaya Laravel memperlakukannya sebagai PUT,
      sesuai route admin.profile.update.
    --}}
    <form method="POST" action="{{ route('admin.profile.update') }}" class="max-w-2xl space-y-5">
        @csrf
        @method('PUT')

        <x-field name="name" label="Nama" :value="$profile->name" required />
        <x-field name="role" label="Peran" :value="$profile->role" required />
        <x-field name="location" label="Lokasi" :value="$profile->location" required />
        <x-field name="availability" label="Ketersediaan" :value="$profile->availability" required />
        <x-field name="tagline" label="Tagline" :value="$profile->tagline" rows="2" required />
        <x-field name="bio" label="Bio (pisahkan paragraf dengan baris kosong)" :value="$profile->bio" rows="6" required />
        <x-field name="photo_alt" label="Teks alternatif foto" :value="$profile->photo_alt" required />

        <x-button>Simpan</x-button>
    </form>
@endsection
