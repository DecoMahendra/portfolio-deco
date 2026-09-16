@extends('layouts.admin')

@section('title', 'Project')

@section('content')
    <div class="mb-8 flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-heading">Project</h1>
        <a href="{{ route('admin.projects.create') }}" class="text-sm font-semibold text-accent hover:text-accent-deep">
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
                    <th class="px-4 py-3 font-medium">Teknologi</th>
                    <th class="px-4 py-3 font-medium">Link</th>
                    <th class="px-4 py-3 font-medium"><span class="sr-only">Aksi</span></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-line">
                @forelse ($projects as $project)
                    <tr>
                        <td class="px-4 py-3">{{ $project->sort_order + 1 }}</td>
                        <td class="px-4 py-3 text-heading">{{ $project->name }}</td>
                        <td class="px-4 py-3">{{ implode(', ', $project->tech) }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            {{-- Tampilkan penanda saja, bukan URL panjang, supaya tabel tetap ringkas. --}}
                            @if ($project->repo_url) Repo @endif
                            @if ($project->repo_url && $project->demo_url) · @endif
                            @if ($project->demo_url) Demo @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-4 whitespace-nowrap">
                                <a href="{{ route('admin.projects.edit', $project) }}" class="text-accent hover:text-accent-deep">Edit</a>
                                <form method="POST" action="{{ route('admin.projects.destroy', $project) }}"
                                      data-confirm="Hapus project ini?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-danger hover:underline">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-faint">Belum ada project.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
