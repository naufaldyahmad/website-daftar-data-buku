@extends('layouts.app')

@section('judul', 'Katalog Buku')

@section('konten')

    {{-- Header Halaman & Pencarian --}}
    <div class="mb-8">

        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                    Katalog Buku
                </h1>
                <p class="text-sm text-slate-500 mt-1">
                    Jelajahi koleksi buku perpustakaan mini berdasarkan judul, penulis, kategori, atau penerbit.
                </p>
            </div>

            @auth
                <a href="{{ route('buku.create') }}"
                   class="self-start md:self-auto inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Tambah Buku Baru</span>
                </a>
            @endauth
        </div>

        {{-- Form Pencarian --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-3 sm:p-4">
            <form action="{{ route('buku.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2.5">

                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input
                        type="text"
                        name="cari"
                        value="{{ $cari }}"
                        placeholder="Cari judul, penulis, kategori, penerbit..."
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                    >
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit"
                            class="flex-1 sm:flex-none inline-flex items-center justify-center gap-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow-sm transition">
                        <span>Cari</span>
                    </button>

                    @if ($cari)
                        <a href="{{ route('buku.index') }}"
                           class="flex-1 sm:flex-none inline-flex items-center justify-center gap-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold px-4 py-2.5 rounded-xl transition">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            <span>Reset</span>
                        </a>
                    @endif
                </div>

            </form>

            @if ($cari)
                <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <div>
                        Menampilkan hasil untuk: <span class="font-semibold text-slate-800">"{{ $cari }}"</span>
                        ({{ $daftarBuku->total() }} buku ditemukan)
                    </div>
                    <a href="{{ route('buku.index') }}" class="text-indigo-600 hover:underline">Hapus filter</a>
                </div>
            @endif
        </div>

    </div>

    {{-- Daftar Buku (Grid Card) --}}
    @if ($daftarBuku->count() > 0)

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach ($daftarBuku as $buku)

                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md border border-slate-200/90 transition-all duration-200 flex flex-col justify-between overflow-hidden group">

                    {{-- Isi Kartu --}}
                    <div class="p-5 sm:p-6">

                        {{-- Header Kartu: Kategori & Tahun --}}
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                🏷️ {{ $buku->kategori ?: 'Umum' }}
                            </span>

                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-600">
                                📅 {{ $buku->tahun_terbit }}
                            </span>
                        </div>

                        {{-- Judul Buku --}}
                        <h2 class="text-lg font-bold text-slate-900 group-hover:text-indigo-600 transition-colors line-clamp-2 leading-snug mb-3">
                            <a href="{{ route('buku.show', $buku) }}">
                                {{ $buku->judul }}
                            </a>
                        </h2>

                        {{-- Metadata: Penulis & Penerbit --}}
                        <div class="space-y-1.5 text-xs text-slate-600 mb-4">
                            <div class="flex items-center gap-1.5 truncate">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span>Penulis: <strong class="text-slate-800 font-medium">{{ $buku->penulis }}</strong></span>
                            </div>

                            <div class="flex items-center gap-1.5 truncate">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <span>Penerbit: <strong class="text-slate-800 font-medium">{{ $buku->penerbit ?: '-' }}</strong></span>
                            </div>
                        </div>

                        {{-- Sinopsis Cuplikan --}}
                        <p class="text-xs text-slate-500 leading-relaxed line-clamp-3">
                            {{ $buku->sinopsis ?: 'Belum ada ringkasan atau sinopsis untuk buku ini.' }}
                        </p>

                    </div>

                    {{-- Footer Kartu: Tombol Aksi --}}
                    <div class="px-5 py-3.5 bg-slate-50/80 border-t border-slate-100 flex items-center justify-between gap-2">

                        {{-- Tombol Detail (Semua Pengunjung) --}}
                        <a href="{{ route('buku.show', $buku) }}"
                           class="inline-flex items-center gap-1 text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition">
                            <span>Detail</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                        {{-- Tombol Aksi Admin (Hanya Jika Login) --}}
                        @auth
                            <div class="flex items-center gap-1.5">

                                {{-- Tombol Edit --}}
                                <a href="{{ route('buku.edit', $buku) }}"
                                   title="Ubah data buku"
                                   class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100 text-xs font-semibold transition border border-amber-200/60">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    <span>Ubah</span>
                                </a>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('buku.destroy', $buku) }}"
                                      method="POST"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku \'{{ addslashes($buku->judul) }}\'? Tindakan ini tidak dapat dibatalkan.')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            title="Hapus buku"
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 text-xs font-semibold transition border border-red-200/60">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        <span>Hapus</span>
                                    </button>
                                </form>

                            </div>
                        @endauth

                    </div>

                </div>

            @endforeach

        </div>

    @else

        {{-- Tampilan Kosong --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center max-w-lg mx-auto shadow-sm my-6">
            <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-2xl flex items-center justify-center mx-auto mb-4 text-3xl">
                📖
            </div>
            <h2 class="text-xl font-bold text-slate-800 mb-1">
                Tidak ada buku yang ditemukan
            </h2>
            <p class="text-sm text-slate-500 mb-6">
                @if ($cari)
                    Tidak ada buku yang cocok dengan kata kunci <span class="font-semibold text-slate-700">"{{ $cari }}"</span>. Silakan coba kata kunci lain.
                @else
                    Belum ada koleksi buku yang tersedia di perpustakaan.
                @endif
            </p>

            <div class="flex justify-center gap-3">
                @if ($cari)
                    <a href="{{ route('buku.index') }}"
                       class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2 rounded-xl transition">
                        <span>Lihat Semua Buku</span>
                    </a>
                @elseif (Auth::check())
                    <a href="{{ route('buku.create') }}"
                       class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2 rounded-xl transition">
                        <span>+ Tambah Buku Pertama</span>
                    </a>
                @endif
            </div>
        </div>

    @endif

    {{-- Navigasi Pagination (5 buku per halaman) --}}
    <div class="mt-8 flex justify-center">
        {{ $daftarBuku->links() }}
    </div>

@endsection
