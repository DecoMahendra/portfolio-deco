@extends('layouts.admin')

@section('title', 'Sertifikat')

@section('content')
    <div class="mb-8 flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-heading">Sertifikat</h1>
        <a href="{{ route('admin.certificates.create') }}" class="text-sm font-semibold text-accent hover:text-accent-deep">
            + Tambah
        </a>
    </div>

    {{-- overflow-x-auto: tabel lebar digeser di dalam kotak ini. overscroll-x-contain: geseran berhenti di kotak, tidak bocor ke halaman. --}}
    <div class="overflow-x-auto overscroll-x-contain rounded-lg border border-line">
        <table class="w-full text-left text-sm">
            <thead class="bg-surface text-faint">
                <tr>
                    <th class="px-4 py-3 font-medium">Urutan</th>
                    <th class="px-4 py-3 font-medium">Nama</th>
                    <th class="px-4 py-3 font-medium">Penyelenggara</th>
                    <th class="px-4 py-3 font-medium">Tahun</th>
                    <th class="px-4 py-3 font-medium"><span class="sr-only">Aksi</span></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-line">
                @forelse ($certificates as $certificate)
                    <tr>
                        <td class="px-4 py-3">{{ $certificate->sort_order + 1 }}</td>
                        <td class="px-4 py-3 text-heading">{{ $certificate->name }}</td>
                        <td class="px-4 py-3">{{ $certificate->organizer }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $certificate->year }}</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-4 whitespace-nowrap">
                                <a href="{{ route('admin.certificates.edit', $certificate) }}" class="text-accent hover:text-accent-deep">Edit</a>
                                <form method="POST" action="{{ route('admin.certificates.destroy', $certificate) }}"
                                      data-confirm="Hapus sertifikat ini?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-danger hover:underline">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-faint">Belum ada sertifikat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
