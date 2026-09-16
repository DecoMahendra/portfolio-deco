@extends('layouts.admin')

@section('title', 'Ubah Pendidikan')

@section('content')
    <h1 class="mb-8 text-2xl font-semibold text-heading">Ubah Pendidikan</h1>

    <form method="POST" action="{{ route('admin.education.update', $education) }}" class="max-w-2xl space-y-5">
        @csrf
        @method('PUT')
        @include('admin.education._form')
        <div class="flex items-center gap-5">
            <x-button>Simpan</x-button>
            <a href="{{ route('admin.education.index') }}" class="text-sm text-faint hover:text-heading">Batal</a>
        </div>
    </form>
@endsection
