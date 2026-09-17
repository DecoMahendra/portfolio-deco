@extends('layouts.admin')

@section('title', 'Tambah Project')

@section('content')
    <h1 class="mb-8 text-2xl font-semibold text-heading">Tambah Project</h1>

    <form method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data" class="max-w-2xl space-y-5">
        @csrf
        @include('admin.projects._form', ['project' => null])
        <div class="flex items-center gap-5">
            <x-button>Tambah</x-button>
            <a href="{{ route('admin.projects.index') }}" class="text-sm text-faint hover:text-heading">Batal</a>
        </div>
    </form>
@endsection
