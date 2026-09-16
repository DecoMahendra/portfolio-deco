@extends('layouts.admin')

@section('title', 'Tambah Pendidikan')

@section('content')
    <h1 class="mb-8 text-2xl font-semibold text-heading">Tambah Pendidikan</h1>

    <form method="POST" action="{{ route('admin.education.store') }}" class="max-w-2xl space-y-5">
        @csrf
        @include('admin.education._form', ['education' => null])
        <div class="flex items-center gap-5">
            <x-button>Tambah</x-button>
            <a href="{{ route('admin.education.index') }}" class="text-sm text-faint hover:text-heading">Batal</a>
        </div>
    </form>
@endsection
