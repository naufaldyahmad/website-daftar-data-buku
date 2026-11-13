@extends('layouts.app')

@section('judul', 'Ubah: ' . $buku->judul)

@section('konten')

    <div class="max-w-2xl mx-auto">

        {{-- Navigasi Kembali --}}
        <div class="mb-5">
            <a href="{{ route('buku.show', $buku) }}"
               class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 hover:text-indigo-600 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Kembali ke Detail Buku</span>
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sm:p-8">

            <div class="mb-6 pb-6 border-b border-slate-100">
                <h1 class="text-2xl font-bold text-slate-900">
                    Ubah Data Buku
                </h1>
                <p class="text-sm text-slate-500 mt-1">
                    Memperbarui data untuk <span class="font-medium text-slate-800">"{{ $buku->judul }}"</span>.
                </p>
            </div>

            <form action="{{ route('buku.update', $buku) }}" method="POST">
                @csrf
                @method('PUT')

                @include('buku._form')

                <div class="mt-8 pt-6 border-t border-slate-100 flex flex-wrap items-center gap-3">

                    <button type="submit"
                            class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow-sm transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Simpan Perubahan</span>
                    </button>

                    <a href="{{ route('buku.show', $buku) }}"
                       class="inline-flex items-center px-4 py-2.5 rounded-xl border border-slate-300 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                        Batal
                    </a>

                </div>

            </form>

        </div>

    </div>

@endsection
