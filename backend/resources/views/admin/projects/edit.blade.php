@extends('layouts.admin')

@section('title', 'Ubah Project')

@section('content')
    <h1 class="mb-8 text-2xl font-semibold text-heading">Ubah Project</h1>

    {{-- enctype multipart: wajib untuk form yang mengirim file. --}}
    <form method="POST" action="{{ route('admin.projects.update', $project) }}" enctype="multipart/form-data" class="max-w-2xl space-y-5">
        @csrf
        @method('PUT')
        @include('admin.projects._form')
        <div class="flex items-center gap-5">
            <x-button>Simpan</x-button>
            <a href="{{ route('admin.projects.index') }}" class="text-sm text-faint hover:text-heading">Batal</a>
        </div>
    </form>

    {{--
      Form hapus per gambar, di luar form utama (form tidak bisa bersarang).
      Tombol "Hapus" di dalam form utama menunjuk ke sini lewat atribut form="...".
    --}}
    @foreach ($project->images as $image)
        <form id="delete-image-{{ $image->id }}" method="POST" action="{{ route('admin.project-images.destroy', $image) }}" data-confirm="Hapus gambar ini?">
            @csrf
            @method('DELETE')
        </form>
    @endforeach
@endsection
