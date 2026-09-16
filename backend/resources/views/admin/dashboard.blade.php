@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <h1 class="mb-2 text-2xl font-semibold text-heading">Dashboard</h1>
    <p class="mb-8 text-sm text-faint">Ringkasan isi website. Halaman pengelolaan tiap bagian menyusul.</p>

    <ul class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($counts as $label => $count)
            <li class="rounded-lg border border-line bg-surface p-5">
                <p class="text-3xl font-semibold text-heading">{{ $count }}</p>
                <p class="mt-1 text-sm">{{ $label }}</p>
            </li>
        @endforeach
    </ul>
@endsection
