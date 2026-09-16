@extends('layouts.admin')

@section('title', 'Ubah Pengalaman')

@section('content')
    <h1 class="mb-8 text-2xl font-semibold text-heading">Ubah Pengalaman</h1>

    <form method="POST" action="{{ route('admin.experiences.update', $experience) }}" class="max-w-2xl space-y-5">
        @csrf
        @method('PUT')
        @include('admin.experiences._form')
        <div class="flex items-center gap-5">
            <x-button>Simpan</x-button>
            <a href="{{ route('admin.experiences.index') }}" class="text-sm text-faint hover:text-heading">Batal</a>
        </div>
    </form>
@endsection
