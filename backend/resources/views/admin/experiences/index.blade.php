@extends('layouts.admin')

@section('title', 'Pengalaman')

@section('content')
    <div class="mb-8 flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-heading">Pengalaman</h1>
        <a href="{{ route('admin.experiences.create') }}" class="text-sm font-semibold text-accent hover:text-accent-deep">
            + Tambah
        </a>
    </div>

    {{-- Tabel dibungkus overflow-x-auto supaya di layar HP bisa digeser, bukan meluber. --}}
    <div class="overflow-x-auto rounded-lg border border-line">
        <table class="w-full text-left text-sm">
            <thead class="bg-surface text-faint">
                <tr>
                    <th class="px-4 py-3 font-medium">Urutan</th>
                    <th class="px-4 py-3 font-medium">Peran</th>
                    <th class="px-4 py-3 font-medium">Tempat</th>
                    <th class="px-4 py-3 font-medium">Periode</th>
                    <th class="px-4 py-3 font-medium"><span class="sr-only">Aksi</span></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-line">
                @forelse ($experiences as $experience)
                    <tr>
                        <td class="px-4 py-3">{{ $experience->sort_order }}</td>
                        <td class="px-4 py-3 text-heading">{{ $experience->role }}</td>
                        <td class="px-4 py-3">{{ $experience->company }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $experience->period }}</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-4 whitespace-nowrap">
                                <a href="{{ route('admin.experiences.edit', $experience) }}" class="text-accent hover:text-accent-deep">Edit</a>

                                {{-- Hapus lewat form POST + DELETE, dengan konfirmasi dulu. --}}
                                <form method="POST" action="{{ route('admin.experiences.destroy', $experience) }}"
                                      onsubmit="return confirm('Hapus pengalaman ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-danger hover:underline">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-faint">Belum ada pengalaman.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
