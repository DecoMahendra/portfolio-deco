@extends('layouts.admin')

@section('title', 'Tambah Skill')

@section('content')
    <h1 class="mb-8 text-2xl font-semibold text-heading">Tambah Skill</h1>

    <form method="POST" action="{{ route('admin.skills.store') }}" class="max-w-2xl space-y-5">
        @csrf
        @include('admin.skills._form', ['skill' => null])
        <div class="flex items-center gap-5">
            <x-button>Tambah</x-button>
            <a href="{{ route('admin.skill-groups.index') }}" class="text-sm text-faint hover:text-heading">Batal</a>
        </div>
    </form>
@endsection
