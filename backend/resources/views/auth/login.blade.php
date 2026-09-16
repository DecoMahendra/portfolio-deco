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
                <input
                    type="password" id="password" name="password"
                    required autocomplete="current-password"
                    class="w-full rounded-md border border-line bg-surface px-3 py-2 text-heading"
                >
            </div>

            <x-button class="w-full">Masuk</x-button>
        </form>
    </main>

</body>
</html>
