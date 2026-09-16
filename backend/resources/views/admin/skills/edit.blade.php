@extends('layouts.admin')

@section('title', 'Ubah Skill')

@section('content')
    <h1 class="mb-8 text-2xl font-semibold text-heading">Ubah Skill</h1>

    <form method="POST" action="{{ route('admin.skills.update', $skill) }}" class="max-w-2xl space-y-5">
        @csrf
        @method('PUT')
        @include('admin.skills._form')
        <div class="flex items-center gap-5">
            <x-button>Simpan</x-button>
            <a href="{{ route('admin.skill-groups.index') }}" class="text-sm text-faint hover:text-heading">Batal</a>
        </div>
    </form>
@endsection
