{{--
  Halaman login berdiri sendiri, tidak memakai layout admin,
  karena belum ada tombol "Keluar" atau navigasi untuk ditampilkan.
--}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — Admin Portfolio</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen items-center justify-center px-6">

    <main class="w-full max-w-sm">
        <h1 class="mb-8 text-2xl font-semibold text-heading">
            Admin <span class="text-accent">Portfolio</span>
        </h1>

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="mb-1.5 block text-sm">Email</label>
                <input
                    type="email" id="email" name="email" value="{{ old('email') }}"
                    required autofocus autocomplete="email"
                    class="w-full rounded-md border border-line bg-surface px-3 py-2 text-heading"
                >
                {{-- @error menampilkan pesan validasi untuk field ini, kalau ada. --}}
                @error('email')
                    <p class="mt-1.5 text-sm text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="mb-1.5 block text-sm">Password</label>
                {{-- relative: patokan posisi tombol mata di dalam kotak. pr-12 pada input
                     supaya teks password tidak tertutup tombolnya. --}}
                <div class="relative">
                    <input
                        type="password" id="password" name="password"
                        required autocomplete="current-password"
                        class="w-full rounded-md border border-line bg-surface py-2 pl-3 pr-12 text-heading"
                    >
                    {{--
                      type="button": tanpa ini, tombol di dalam form dianggap tombol kirim.
                      size-11 = 44px (area sentuh minimal); top-1/2 + -translate-y-1/2 menaruhnya
                      tepat di tengah tinggi kotak. Logikanya di resources/js/app.js.
                    --}}
                    <button
                        type="button" id="password-toggle"
                        aria-controls="password" aria-label="Tampilkan password"
                        class="absolute right-0 top-1/2 flex size-11 -translate-y-1/2 items-center justify-center rounded-md text-faint hover:text-heading"
                    >
                        {{-- Mata terbuka: ditampilkan saat password tersembunyi. --}}
                        <svg data-icon="show" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                        {{-- Mata dicoret: ditampilkan saat password sedang terlihat. --}}
                        <svg data-icon="hide" class="hidden" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M10.7 5.1A10.4 10.4 0 0 1 12 5c6.5 0 10 7 10 7a17.6 17.6 0 0 1-2.2 3.2M6.6 6.6C3.9 8.4 2 12 2 12s3.5 7 10 7c1.9 0 3.6-.6 5.1-1.5" />
                            <path d="M9.9 9.9a3 3 0 0 0 4.2 4.2" />
                            <path d="M2 2l20 20" />
                        </svg>
                    </button>
                </div>
            </div>

            <x-button class="w-full">Masuk</x-button>
        </form>
    </main>

</body>
</html>
