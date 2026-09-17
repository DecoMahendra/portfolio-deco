@extends('layouts.admin')

@section('title', 'Tambah Sertifikat')

@section('content')
    <h1 class="mb-8 text-2xl font-semibold text-heading">Tambah Sertifikat</h1>

    <form method="POST" action="{{ route('admin.certificates.store') }}" enctype="multipart/form-data" class="max-w-2xl space-y-5">
        @csrf
        @include('admin.certificates._form', ['certificate' => null])
        <div class="flex items-center gap-5">
            <x-button>Tambah</x-button>
            <a href="{{ route('admin.certificates.index') }}" class="text-sm text-faint hover:text-heading">Batal</a>
        </div>
    </form>
@endsection
