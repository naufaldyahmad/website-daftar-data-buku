{{-- Form parsial yang digunakan bersama oleh halaman Tambah dan Ubah Buku --}}

<div class="space-y-6">

    {{-- Judul Buku --}}
    <div>
        <label for="judul" class="block text-sm font-semibold text-slate-700 mb-1.5">
            Judul Buku <span class="text-red-500">*</span>
        </label>
        <input
            type="text"
            id="judul"
            name="judul"
            value="{{ old('judul', $buku->judul ?? '') }}"
            placeholder="Contoh: Laskar Pelangi"
            class="w-full rounded-xl border px-3.5 py-2.5 text-sm transition focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('judul') border-red-500 bg-red-50/40 @else border-slate-300 @enderror"
        >
        @error('judul')
            <p class="text-xs text-red-600 mt-1.5 flex items-center gap-1 font-medium">
                <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <span>{{ $message }}</span>
            </p>
        @enderror
    </div>

    {{-- Penulis & Penerbit --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

        {{-- Penulis --}}
        <div>
            <label for="penulis" class="block text-sm font-semibold text-slate-700 mb-1.5">
                Nama Penulis <span class="text-red-500">*</span>
            </label>
            <input
                type="text"
                id="penulis"
                name="penulis"
                value="{{ old('penulis', $buku->penulis ?? '') }}"
                placeholder="Contoh: Andrea Hirata"
                class="w-full rounded-xl border px-3.5 py-2.5 text-sm transition focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('penulis') border-red-500 bg-red-50/40 @else border-slate-300 @enderror"
            >
            @error('penulis')
                <p class="text-xs text-red-600 mt-1.5 flex items-center gap-1 font-medium">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ $message }}</span>
                </p>
            @enderror
        </div>

        {{-- Penerbit --}}
        <div>
            <label for="penerbit" class="block text-sm font-semibold text-slate-700 mb-1.5">
                Nama Penerbit <span class="text-red-500">*</span>
            </label>
            <input
                type="text"
                id="penerbit"
                name="penerbit"
                value="{{ old('penerbit', $buku->penerbit ?? '') }}"
                placeholder="Contoh: Bentang Pustaka"
                class="w-full rounded-xl border px-3.5 py-2.5 text-sm transition focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('penerbit') border-red-500 bg-red-50/40 @else border-slate-300 @enderror"
            >
            @error('penerbit')
                <p class="text-xs text-red-600 mt-1.5 flex items-center gap-1 font-medium">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ $message }}</span>
                </p>
            @enderror
        </div>

    </div>

    {{-- Kategori & Tahun Terbit --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

        {{-- Kategori --}}
        <div>
            <label for="kategori" class="block text-sm font-semibold text-slate-700 mb-1.5">
                Kategori Buku <span class="text-red-500">*</span>
            </label>
            <input
                type="text"
                id="kategori"
                name="kategori"
                list="kategori-saran"
                value="{{ old('kategori', $buku->kategori ?? '') }}"
                placeholder="Pilih atau ketik kategori..."
                class="w-full rounded-xl border px-3.5 py-2.5 text-sm transition focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('kategori') border-red-500 bg-red-50/40 @else border-slate-300 @enderror"
            >
            <datalist id="kategori-saran">
                <option value="Fiksi">
                <option value="Fiksi Inspiratif">
                <option value="Sastra">
                <option value="Sastra Sejarah">
                <option value="Sains &amp; Teknologi">
                <option value="Sejarah &amp; Budaya">
                <option value="Biografi">
                <option value="Bisnis &amp; Finansial">
                <option value="Pengembangan Diri">
                <option value="Agama &amp; Filsafat">
                <option value="Komik &amp; Grafis">
            </datalist>
            @error('kategori')
                <p class="text-xs text-red-600 mt-1.5 flex items-center gap-1 font-medium">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ $message }}</span>
                </p>
            @enderror
        </div>

        {{-- Tahun Terbit --}}
        <div>
            <label for="tahun_terbit" class="block text-sm font-semibold text-slate-700 mb-1.5">
                Tahun Terbit <span class="text-red-500">*</span>
            </label>
            <input
                type="number"
                id="tahun_terbit"
                name="tahun_terbit"
                min="1000"
                max="{{ date('Y') }}"
                value="{{ old('tahun_terbit', $buku->tahun_terbit ?? '') }}"
                placeholder="Contoh: {{ date('Y') }}"
                class="w-full rounded-xl border px-3.5 py-2.5 text-sm transition focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('tahun_terbit') border-red-500 bg-red-50/40 @else border-slate-300 @enderror"
            >
            @error('tahun_terbit')
                <p class="text-xs text-red-600 mt-1.5 flex items-center gap-1 font-medium">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ $message }}</span>
                </p>
            @enderror
        </div>

    </div>

    {{-- Sinopsis --}}
    <div>
        <label for="sinopsis" class="block text-sm font-semibold text-slate-700 mb-1.5">
            Sinopsis / Deskripsi Ringkas <span class="text-xs font-normal text-slate-400">(Opsional)</span>
        </label>
        <textarea
            id="sinopsis"
            name="sinopsis"
            rows="4"
            placeholder="Tuliskan ringkasan cerita atau gambaran umum isi buku..."
            class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm transition focus:outline-none focus:ring-2 focus:ring-indigo-500"
        >{{ old('sinopsis', $buku->sinopsis ?? '') }}</textarea>
    </div>

</div>
