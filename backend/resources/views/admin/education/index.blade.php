@extends('layouts.admin')

@section('title', 'Pendidikan')

@section('content')
    <div class="mb-8 flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-heading">Pendidikan</h1>
        <a href="{{ route('admin.education.create') }}" class="text-sm font-semibold text-accent hover:text-accent-deep">
            + Tambah
        </a>
    </div>

    {{-- overflow-x-auto: tabel lebar digeser di dalam kotak ini. overscroll-x-contain: geseran berhenti di kotak, tidak bocor ke halaman. --}}
    <div class="overflow-x-auto overscroll-x-contain rounded-lg border border-line">
        <table class="w-full text-left text-sm">
            <thead class="bg-surface text-faint">
                <tr>
                    <th class="px-4 py-3 font-medium">Urutan</th>
                    <th class="px-4 py-3 font-medium">Sekolah</th>
                    <th class="px-4 py-3 font-medium">Program</th>
                    <th class="px-4 py-3 font-medium">Periode</th>
                    <th class="px-4 py-3 font-medium"><span class="sr-only">Aksi</span></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-line">
                @forelse ($education as $item)
                    <tr>
                        <td class="px-4 py-3">{{ $item->sort_order }}</td>
                        <td class="px-4 py-3 text-heading">{{ $item->school }}</td>
                        <td class="px-4 py-3">{{ $item->program }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $item->period }}</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-4 whitespace-nowrap">
                                <a href="{{ route('admin.education.edit', $item) }}" class="text-accent hover:text-accent-deep">Edit</a>
                                <form method="POST" action="{{ route('admin.education.destroy', $item) }}"
                                      data-confirm="Hapus pendidikan ini?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-danger hover:underline">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-faint">Belum ada pendidikan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
