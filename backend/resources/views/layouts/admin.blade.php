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
                {{-- py-3 -my-3: area sentuh jadi 44px tingginya, lalu margin negatif
                     menariknya kembali supaya tinggi header tidak berubah.
                     Sengaja TIDAK memakai inline-flex di sini: "Admin" dan <span>Portfolio</span>
                     akan jadi dua item flex, dan spasi di antaranya ikut hilang. --}}
                <a href="{{ route('admin.dashboard') }}" class="py-3 -my-3 font-semibold text-heading">
                    Admin <span class="text-accent">Portfolio</span>
                </a>

                <div class="flex items-center gap-4">
                    {{-- Logout harus POST supaya tidak bisa dipicu lewat link biasa (CSRF). --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="inline-flex min-h-11 items-center px-2 -mx-2 text-sm text-faint hover:text-heading">
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

            {{-- Layar kecil: tersembunyi, dibuka lewat tombol, tersusun ke bawah. Layar >= md: selalu tampil sejajar.
                 md:gap-6 (bukan gap-5) dan md:mt-6 (bukan mt-3): tautannya melebar 12px ke
                 segala arah untuk area sentuh, jadi jarak ke tetangga — termasuk ke logo di
                 baris atasnya — harus 24px supaya kotak sentuhnya tidak saling menimpa. --}}
            <nav id="menu" class="mt-4 hidden flex-col gap-1 text-sm md:mt-6 md:flex md:flex-row md:gap-6">
                <a href="{{ route('admin.profile.edit') }}" class="flex min-h-11 items-center hover:text-heading md:min-h-0 md:-my-3 md:-mx-3 md:px-3 md:py-3">Profil</a>
                <a href="{{ route('admin.skill-groups.index') }}" class="flex min-h-11 items-center hover:text-heading md:min-h-0 md:-my-3 md:-mx-3 md:px-3 md:py-3">Skill</a>
                <a href="{{ route('admin.experiences.index') }}" class="flex min-h-11 items-center hover:text-heading md:min-h-0 md:-my-3 md:-mx-3 md:px-3 md:py-3">Pengalaman</a>
                <a href="{{ route('admin.education.index') }}" class="flex min-h-11 items-center hover:text-heading md:min-h-0 md:-my-3 md:-mx-3 md:px-3 md:py-3">Pendidikan</a>
                <a href="{{ route('admin.projects.index') }}" class="flex min-h-11 items-center hover:text-heading md:min-h-0 md:-my-3 md:-mx-3 md:px-3 md:py-3">Project</a>
                <a href="{{ route('admin.certificates.index') }}" class="flex min-h-11 items-center hover:text-heading md:min-h-0 md:-my-3 md:-mx-3 md:px-3 md:py-3">Sertifikat</a>
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-5xl px-6 py-10">
        {{-- Pesan sekali tampil setelah simpan/hapus, dikirim lewat session. --}}
        {{-- Peringatan: misalnya terbitkan gagal karena tidak ada internet. --}}
        @if (session('warning'))
            <p class="mb-6 rounded-md border border-danger bg-raised px-4 py-3 text-sm text-danger">
                {{ session('warning') }}
            </p>
        @endif

        {{--
          Muncul selama isi dashboard berbeda dari yang tampil di website hosting.
          Simpan saja sudah cukup untuk localhost; ini pengingat untuk menerbitkannya.
          min-h-11 pada tombol: kotak ini memakai text-sm, dan tombol ikut mengecil
          sampai 40px — di bawah batas area sentuh 44px.
        --}}
        @if ($hasUnpublishedChanges)
            <div class="mb-6 flex flex-col gap-3 rounded-md border border-line bg-raised px-4 py-3 text-sm sm:flex-row sm:items-center sm:justify-between">
                <p>Ada perubahan yang belum diterbitkan ke website. Cek dulu di localhost, lalu terbitkan kalau sudah sesuai.</p>
                <form method="POST" action="{{ route('admin.publish') }}" class="shrink-0">
                    @csrf
                    <x-button class="min-h-11 w-full sm:w-auto">Terbitkan</x-button>
                </form>
            </div>
        @endif

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
