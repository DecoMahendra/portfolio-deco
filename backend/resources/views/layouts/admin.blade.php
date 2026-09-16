{{--
  Layout = kerangka halaman yang dipakai semua halaman admin.
  Halaman lain tinggal "menempel" isinya lewat @extends + @section('content').
  Mirip App.jsx di React yang membungkus Navbar + isi + Footer.
--}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — Admin Portfolio</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen">

    <header class="border-b border-line bg-surface">
        <div class="mx-auto flex max-w-5xl items-center justify-between px-6 py-4">
            <nav class="flex items-center gap-6 text-sm">
                <a href="{{ route('admin.dashboard') }}" class="font-semibold text-heading">
                    Admin <span class="text-accent">Portfolio</span>
                </a>
                <a href="{{ route('admin.profile.edit') }}" class="hover:text-heading">Profil</a>
                <a href="{{ route('admin.experiences.index') }}" class="hover:text-heading">Pengalaman</a>
            </nav>

            {{-- Logout harus POST supaya tidak bisa dipicu lewat link biasa (CSRF). --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-faint hover:text-heading">
                    Keluar
                </button>
            </form>
        </div>
    </header>

    <main class="mx-auto max-w-5xl px-6 py-10">
        {{-- Pesan sekali tampil setelah simpan/hapus, dikirim lewat session. --}}
        @if (session('status'))
            <p class="mb-6 rounded-md border border-accent-deep bg-raised px-4 py-3 text-sm text-accent">
                {{ session('status') }}
            </p>
        @endif

        @yield('content')
    </main>

</body>
</html>
