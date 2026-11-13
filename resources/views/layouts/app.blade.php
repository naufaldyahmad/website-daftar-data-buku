<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Aplikasi Perpustakaan Mini berbasis Laravel dan Tailwind CSS">

    <title>@yield('judul', 'Katalog Buku') — Perpustakaan Mini</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-full flex flex-col bg-slate-50 text-slate-800 font-sans antialiased">

    {{-- Navigasi Utama --}}
    <header class="bg-indigo-700 text-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                {{-- Brand & Logo --}}
                <a href="{{ route('buku.index') }}" class="flex items-center gap-2.5 group">
                    <span class="text-2xl transition-transform group-hover:scale-110">📚</span>
                    <div>
                        <span class="text-lg font-bold tracking-tight block leading-tight">Perpustakaan Mini</span>
                        <span class="text-xs text-indigo-200 block">Katalog &amp; Koleksi Buku</span>
                    </div>
                </a>

                {{-- Navigasi Kanan --}}
                <div class="flex items-center gap-3">
                    @auth
                        {{-- Menu Khusus Admin --}}
                        <a href="{{ route('buku.create') }}"
                           class="inline-flex items-center gap-1.5 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold px-3.5 py-2 rounded-lg shadow-sm transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span class="hidden sm:inline">Tambah Buku</span>
                        </a>

                        {{-- Identitas Admin --}}
                        <div class="hidden md:flex items-center gap-2 bg-indigo-800/80 px-3 py-1.5 rounded-lg border border-indigo-600/50 text-xs">
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                            <span class="text-indigo-100 font-medium">{{ Auth::user()->name }}</span>
                        </div>

                        {{-- Tombol Logout --}}
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit"
                                    title="Keluar dari akun admin"
                                    class="inline-flex items-center gap-1.5 bg-indigo-800 hover:bg-red-600 text-white text-sm font-medium px-3 py-2 rounded-lg transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                <span class="hidden sm:inline">Keluar</span>
                            </button>
                        </form>
                    @else
                        {{-- Tombol Masuk Admin untuk Tamu --}}
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center gap-1.5 bg-white/10 hover:bg-white text-white hover:text-indigo-700 text-sm font-semibold px-3.5 py-2 rounded-lg border border-white/20 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            <span>Masuk Admin</span>
                        </a>
                    @endauth
                </div>

            </div>
        </div>
    </header>

    {{-- Konten Utama --}}
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Notifikasi Sukses --}}
        @if (session('sukses'))
            <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3.5 flex items-start gap-3 shadow-sm" role="alert">
                <svg class="w-5 h-5 text-emerald-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <div class="font-medium text-sm">
                    {{ session('sukses') }}
                </div>
            </div>
        @endif

        {{-- Notifikasi Peringatan / Error --}}
        @if (session('error'))
            <div class="mb-6 rounded-xl bg-red-50 border border-red-200 text-red-800 px-4 py-3.5 flex items-start gap-3 shadow-sm" role="alert">
                <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <div class="font-medium text-sm">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @yield('konten')

    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t border-slate-200 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-center text-sm text-slate-500">
            <p class="font-medium text-slate-700">Perpustakaan Mini &copy; {{ date('Y') }}</p>
            <p class="text-xs text-slate-400 mt-1">Dibangun dengan Laravel 12, Blade &amp; Tailwind CSS</p>
        </div>
    </footer>

</body>
</html>
