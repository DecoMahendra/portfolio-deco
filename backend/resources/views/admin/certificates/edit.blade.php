@extends('layouts.admin')

@section('title', 'Ubah Sertifikat')

@section('content')
    <h1 class="mb-8 text-2xl font-semibold text-heading">Ubah Sertifikat</h1>

    <form method="POST" action="{{ route('admin.certificates.update', $certificate) }}" class="max-w-2xl space-y-5">
        @csrf
        @method('PUT')
        @include('admin.certificates._form')
        <div class="flex items-center gap-5">
            <x-button>Simpan</x-button>
            <a href="{{ route('admin.certificates.index') }}" class="text-sm text-faint hover:text-heading">Batal</a>
        </div>
    </form>
@endsection
