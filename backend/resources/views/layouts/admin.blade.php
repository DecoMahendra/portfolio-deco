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

    {{-- sticky: header tetap terlihat saat halaman digulir. z-10 supaya selalu di atas isi. --}}
    <header class="sticky top-0 z-10 border-b border-line bg-surface">
        <div class="mx-auto max-w-5xl px-6 py-4">
            <div class="flex items-center justify-between gap-4">
                <a href="{{ route('admin.dashboard') }}" class="font-semibold text-heading">
                    Admin <span class="text-accent">Portfolio</span>
                </a>

                <div class="flex items-center gap-4">
                    {{-- Logout harus POST supaya tidak bisa dipicu lewat link biasa (CSRF). --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-faint hover:text-heading">
                            Keluar
                        </button>
                    </form>

                    {{-- Tombol hamburger, hanya di layar kecil. Logikanya di resources/js/app.js. --}}
                    <button
                        type="button" id="menu-toggle"
                        aria-label="Buka menu" aria-expanded="false" aria-controls="menu"
                        class="-mr-2 flex size-11 items-center justify-center rounded-md text-heading hover:bg-raised md:hidden"
                    >
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
                            <path d="M3 5h14M3 10h14M3 15h14" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Layar kecil: tersembunyi, dibuka lewat tombol, tersusun ke bawah. Layar >= md: selalu tampil sejajar. --}}
            <nav id="menu" class="mt-4 hidden flex-col gap-1 text-sm md:mt-3 md:flex md:flex-row md:gap-5">
                <a href="{{ route('admin.profile.edit') }}" class="py-2 hover:text-heading md:py-0">Profil</a>
                <a href="{{ route('admin.experiences.index') }}" class="py-2 hover:text-heading md:py-0">Pengalaman</a>
                <a href="{{ route('admin.education.index') }}" class="py-2 hover:text-heading md:py-0">Pendidikan</a>
                <a href="{{ route('admin.projects.index') }}" class="py-2 hover:text-heading md:py-0">Project</a>
                <a href="{{ route('admin.certificates.index') }}" class="py-2 hover:text-heading md:py-0">Sertifikat</a>
            </nav>
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

    {{--
      Dialog konfirmasi hapus, satu untuk semua halaman. Isi <p> diganti oleh JS
      sesuai data-confirm di form yang dikirim. <form method="dialog"> = cara
      bawaan HTML menutup dialog; value tombol yang ditekan masuk ke returnValue.
    --}}
    <dialog id="confirm-dialog" class="m-auto w-[calc(100%-3rem)] max-w-sm rounded-lg border border-line bg-raised p-6 text-body backdrop:bg-page/80">
        <p class="text-heading"></p>
        <form method="dialog" class="mt-6 flex justify-end gap-3">
            <button value="cancel" class="rounded-md px-4 py-2 text-sm hover:text-heading">Batal</button>
            <button value="confirm" class="rounded-md bg-danger px-4 py-2 text-sm font-semibold text-page hover:opacity-90">Hapus</button>
        </form>
    </dialog>

</body>
</html>
