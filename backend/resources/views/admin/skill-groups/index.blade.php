@extends('layouts.admin')

@section('title', 'Skill')

@section('content')
    <div class="mb-8 flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-heading">Skill</h1>
        <a href="{{ route('admin.skill-groups.create') }}" class="text-sm font-semibold text-accent hover:text-accent-deep">
            + Tambah kelompok
        </a>
    </div>

    {{-- Satu kartu per kelompok; skill-nya ditampilkan di dalam kartu itu. --}}
    <div class="space-y-5">
        @forelse ($groups as $group)
            <section class="rounded-lg border border-line bg-surface p-5">
                <div class="flex items-start justify-between gap-4">
                    <h2 class="font-semibold text-heading">
                        {{ $group->name }}
                        <span class="ml-2 text-sm font-normal text-faint">urutan {{ $group->sort_order + 1 }}</span>
                    </h2>

                    <div class="flex gap-4 whitespace-nowrap text-sm">
                        <a href="{{ route('admin.skill-groups.edit', $group) }}" class="text-accent hover:text-accent-deep">Edit</a>
                        <form method="POST" action="{{ route('admin.skill-groups.destroy', $group) }}"
                              data-confirm="Hapus kelompok “{{ $group->name }}” beserta {{ $group->skills->count() }} skill di dalamnya?">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-danger hover:underline">Hapus</button>
                        </form>
                    </div>
                </div>

                <ul class="mt-4 flex flex-wrap gap-2">
                    @foreach ($group->skills as $skill)
                        <li class="flex items-center gap-3 rounded-md border border-line bg-raised px-3 py-1.5 text-sm">
                            <span class="text-heading">{{ $skill->name }}</span>
                            <a href="{{ route('admin.skills.edit', $skill) }}" class="text-faint hover:text-heading" aria-label="Ubah skill {{ $skill->name }}">Edit</a>
                            <form method="POST" action="{{ route('admin.skills.destroy', $skill) }}"
                                  data-confirm="Hapus skill “{{ $skill->name }}”?">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-faint hover:text-danger" aria-label="Hapus skill {{ $skill->name }}">Hapus</button>
                            </form>
                        </li>
                    @endforeach

                    <li>
                        {{-- ?group= mengisi dropdown kelompok di form tambah secara otomatis. --}}
                        <a href="{{ route('admin.skills.create', ['group' => $group->id]) }}"
                           class="flex items-center rounded-md border border-dashed border-line px-3 py-1.5 text-sm text-accent hover:text-accent-deep">
                            + Tambah skill
                        </a>
                    </li>
                </ul>
            </section>
        @empty
            <p class="rounded-lg border border-line px-4 py-8 text-center text-faint">Belum ada kelompok skill.</p>
        @endforelse
    </div>
@endsection
