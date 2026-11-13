<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BukuController extends Controller
{
    /**
     * Menampilkan daftar buku dengan pencarian dan pagination.
     */
    public function index(Request $request): View
    {
        $cari = $request->query('cari');

        $daftarBuku = Buku::query()
            ->when($cari, function ($query, $cari) {
                $query->where(function ($sub) use ($cari) {
                    $sub->where('judul', 'like', "%{$cari}%")
                        ->orWhere('penulis', 'like', "%{$cari}%")
                        ->orWhere('kategori', 'like', "%{$cari}%")
                        ->orWhere('penerbit', 'like', "%{$cari}%");
                });
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('buku.index', compact('daftarBuku', 'cari'));
    }

    /**
     * Menampilkan form tambah buku (khusus admin).
     */
    public function create(): View
    {
        return view('buku.create');
    }

    /**
     * Menyimpan buku baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->aturan(), $this->pesan());

        Buku::create($data);

        return redirect()->route('buku.index')
            ->with('sukses', 'Buku berhasil ditambahkan ke perpustakaan.');
    }

    /**
     * Menampilkan detail buku.
     */
    public function show(Buku $buku): View
    {
        return view('buku.show', compact('buku'));
    }

    /**
     * Menampilkan form ubah buku (khusus admin).
     */
    public function edit(Buku $buku): View
    {
        return view('buku.edit', compact('buku'));
    }

    /**
     * Menyimpan perubahan data buku ke database.
     */
    public function update(Request $request, Buku $buku): RedirectResponse
    {
        $data = $request->validate($this->aturan(), $this->pesan());

        $buku->update($data);

        return redirect()->route('buku.show', $buku)
            ->with('sukses', 'Data buku berhasil diperbarui.');
    }

    /**
     * Menghapus buku dari database (khusus admin).
     */
    public function destroy(Buku $buku): RedirectResponse
    {
        $buku->delete();

        return redirect()->route('buku.index')
            ->with('sukses', 'Buku berhasil dihapus dari perpustakaan.');
    }

    /**
     * Aturan validasi input buku.
     */
    private function aturan(): array
    {
        return [
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'penerbit' => 'required|string|max:150',
            'tahun_terbit' => 'required|integer|min:1000|max:'.date('Y'),
            'sinopsis' => 'nullable|string',
        ];
    }

    /**
     * Pesan validasi dalam bahasa Indonesia.
     */
    private function pesan(): array
    {
        return [
            'judul.required' => 'Judul buku wajib diisi.',
            'judul.max' => 'Judul buku tidak boleh melebihi 255 karakter.',
            'penulis.required' => 'Nama penulis wajib diisi.',
            'penulis.max' => 'Nama penulis tidak boleh melebihi 255 karakter.',
            'kategori.required' => 'Kategori buku wajib diisi.',
            'kategori.max' => 'Kategori buku tidak boleh melebihi 100 karakter.',
            'penerbit.required' => 'Nama penerbit wajib diisi.',
            'penerbit.max' => 'Nama penerbit tidak boleh melebihi 150 karakter.',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi.',
            'tahun_terbit.integer' => 'Tahun terbit harus berupa angka.',
            'tahun_terbit.min' => 'Tahun terbit tidak valid (minimal tahun 1000).',
            'tahun_terbit.max' => 'Tahun terbit tidak boleh melebihi tahun sekarang ('.date('Y').').',
        ];
    }
}
