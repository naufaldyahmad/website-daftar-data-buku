@extends('layouts.app')

@section('judul', 'Masuk Admin')

@section('konten')

    <div class="max-w-md mx-auto my-8">

        {{-- Kartu Info Demo --}}
        <div class="mb-6 p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 text-sm shadow-sm">
            <div class="flex items-center gap-2 font-semibold text-amber-800 mb-1">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <span>Akun Bawaan Admin</span>
            </div>
            <p class="text-xs text-amber-700 mb-2">Gunakan akun berikut untuk menguji fitur administrasi:</p>
            <div class="bg-white/80 rounded-lg p-2 font-mono text-xs space-y-1 border border-amber-200/60">
                <p><span class="text-slate-500">Email:</span> <strong class="text-slate-900">admin@perpustakaan.test</strong></p>
                <p><span class="text-slate-500">Sandi:</span> <strong class="text-slate-900">password123</strong></p>
            </div>
        </div>

        {{-- Form Login Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sm:p-8">

            <div class="text-center mb-6">
                <div class="w-12 h-12 bg-indigo-50 text-indigo-700 rounded-2xl flex items-center justify-center mx-auto mb-3 text-2xl shadow-inner">
                    🔐
                </div>
                <h1 class="text-2xl font-bold text-slate-900">Masuk Admin</h1>
                <p class="text-sm text-slate-500 mt-1">
                    Silakan masukkan email dan kata sandi Anda.
                </p>
            </div>

            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf

                {{-- Input Email --}}
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-1">
                        Alamat Email
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', 'admin@perpustakaan.test') }}"
                        required
                        autofocus
                        autocomplete="email"
                        placeholder="nama@email.com"
                        class="w-full rounded-xl border px-3.5 py-2.5 text-sm transition focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('email') border-red-500 bg-red-50/50 @else border-slate-300 @enderror"
                    >
                    @error('email')
                        <p class="text-xs text-red-600 mt-1 flex items-center gap-1 font-medium">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                {{-- Input Password --}}
                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-1">
                        Kata Sandi
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••"
                        class="w-full rounded-xl border px-3.5 py-2.5 text-sm transition focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('password') border-red-500 bg-red-50/50 @else border-slate-300 @enderror"
                    >
                    @error('password')
                        <p class="text-xs text-red-600 mt-1 flex items-center gap-1 font-medium">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                {{-- Ingat Saya --}}
                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer text-sm text-slate-600">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                        <span>Ingat saya di perangkat ini</span>
                    </label>
                </div>

                {{-- Tombol Submit --}}
                <div class="pt-2">
                    <button type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-4 rounded-xl shadow-sm transition flex items-center justify-center gap-2">
                        <span>Masuk ke Pengelolaan</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </div>

            </form>

            <div class="mt-6 pt-6 border-t border-slate-100 text-center">
                <a href="{{ route('buku.index') }}"
                   class="text-sm font-medium text-slate-500 hover:text-indigo-600 transition inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Kembali ke Katalog Publik</span>
                </a>
            </div>

        </div>

    </div>

@endsection
