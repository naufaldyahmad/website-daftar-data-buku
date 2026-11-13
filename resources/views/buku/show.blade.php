@extends('layouts.app')

@section('judul', $buku->judul)

@section('konten')

    <div class="max-w-3xl mx-auto">

        {{-- Navigasi Kembali --}}
        <div class="mb-5 flex items-center justify-between">
            <a href="{{ route('buku.index') }}"
               class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-600 hover:text-indigo-600 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Kembali ke Katalog</span>
            </a>

            @auth
                <div class="flex items-center gap-2">
                    <a href="{{ route('buku.edit', $buku) }}"
                       class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold shadow-sm transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <span>Ubah</span>
                    </a>

                    <form action="{{ route('buku.destroy', $buku) }}"
                          method="POST"
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku \'{{ addslashes($buku->judul) }}\'? Tindakan ini tidak dapat dibatalkan.')">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-red-50 hover:bg-red-600 text-red-600 hover:text-white border border-red-200 hover:border-transparent text-xs font-semibold transition">
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

        {{-- Kartu Detail Buku --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

            <div class="p-6 sm:p-8">

                {{-- Badges --}}
                <div class="flex flex-wrap items-center gap-2 mb-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                        🏷️ {{ $buku->kategori ?: 'Umum' }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">
                        📅 Terbit Tahun {{ $buku->tahun_terbit }}
                    </span>
                </div>

                {{-- Judul Buku --}}
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight leading-tight mb-6">
                    {{ $buku->judul }}
                </h1>

                {{-- Grid Informasi Detail --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 rounded-xl bg-slate-50 border border-slate-100 mb-8">

                    {{-- Penulis --}}
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0 text-base">
                            ✍️
                        </div>
                        <div>
                            <span class="block text-xs uppercase tracking-wider font-semibold text-slate-400">Penulis</span>
                            <span class="block text-sm font-bold text-slate-800">{{ $buku->penulis }}</span>
                        </div>
                    </div>

                    {{-- Penerbit --}}
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 text-base">
                            🏢
                        </div>
                        <div>
                            <span class="block text-xs uppercase tracking-wider font-semibold text-slate-400">Penerbit</span>
                            <span class="block text-sm font-bold text-slate-800">{{ $buku->penerbit ?: 'Tidak dicantumkan' }}</span>
                        </div>
                    </div>

                    {{-- Kategori --}}
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center shrink-0 text-base">
                            📚
                        </div>
                        <div>
                            <span class="block text-xs uppercase tracking-wider font-semibold text-slate-400">Kategori</span>
                            <span class="block text-sm font-bold text-slate-800">{{ $buku->kategori ?: 'Umum' }}</span>
                        </div>
                    </div>

                    {{-- Tahun Terbit --}}
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center shrink-0 text-base">
                            📆
                        </div>
                        <div>
                            <span class="block text-xs uppercase tracking-wider font-semibold text-slate-400">Tahun Terbit</span>
                            <span class="block text-sm font-bold text-slate-800">{{ $buku->tahun_terbit }}</span>
                        </div>
                    </div>

                </div>

                {{-- Sinopsis / Deskripsi --}}
                <div>
                    <h2 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-3">
                        Sinopsis / Ringkasan Buku
                    </h2>
                    <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed text-sm whitespace-pre-line bg-slate-50/50 p-5 rounded-xl border border-slate-100">
                        {{ $buku->sinopsis ?: 'Belum ada sinopsis untuk buku ini.' }}
                    </div>
                </div>

            </div>

            {{-- Footer Aksi --}}
            <div class="px-6 sm:px-8 py-4 bg-slate-50 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3">
                <a href="{{ route('buku.index') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl border border-slate-300 text-xs font-semibold text-slate-700 hover:bg-white transition shadow-2xs">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Kembali ke Daftar Buku</span>
                </a>

                @auth
                    <div class="flex items-center gap-2">
                        <a href="{{ route('buku.edit', $buku) }}"
                           class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold shadow-sm transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            <span>Ubah Data Ini</span>
                        </a>
                    </div>
                @endauth
            </div>

        </div>

    </div>

@endsection
