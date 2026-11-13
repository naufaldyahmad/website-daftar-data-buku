<?php

namespace Tests\Feature;

use App\Models\Buku;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BukuTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'name' => 'Admin Perpustakaan',
            'email' => 'admin@perpustakaan.test',
            'password' => bcrypt('password123'),
        ]);
    }

    /**
     * Tamu dapat melihat halaman katalog buku.
     */
    public function test_tamu_dapat_melihat_katalog_buku(): void
    {
        Buku::create([
            'judul' => 'Laskar Pelangi',
            'penulis' => 'Andrea Hirata',
            'kategori' => 'Fiksi Inspiratif',
            'penerbit' => 'Bentang Pustaka',
            'tahun_terbit' => 2005,
            'sinopsis' => 'Kisah anak-anak Belitong.',
        ]);

        $response = $this->get('/buku');

        $response->assertStatus(200);
        $response->assertSee('Laskar Pelangi');
        $response->assertSee('Andrea Hirata');
        $response->assertSee('Fiksi Inspiratif');
        $response->assertSee('Bentang Pustaka');
    }

    /**
     * Tamu dapat melihat halaman detail buku.
     */
    public function test_tamu_dapat_melihat_detail_buku(): void
    {
        $buku = Buku::create([
            'judul' => 'Bumi Manusia',
            'penulis' => 'Pramoedya Ananta Toer',
            'kategori' => 'Sastra Sejarah',
            'penerbit' => 'Hasta Mitra',
            'tahun_terbit' => 1980,
            'sinopsis' => 'Kisah perjuangan Minke.',
        ]);

        $response = $this->get('/buku/'.$buku->id);

        $response->assertStatus(200);
        $response->assertSee('Bumi Manusia');
        $response->assertSee('Pramoedya Ananta Toer');
        $response->assertSee('Sastra Sejarah');
        $response->assertSee('Hasta Mitra');
        $response->assertSee('Kisah perjuangan Minke.');
    }

    /**
     * Tamu tidak dapat mengakses form tambah buku dan diarahkan ke login.
     */
    public function test_tamu_tidak_dapat_mengakses_form_tambah(): void
    {
        $response = $this->get('/buku/create');

        $response->assertRedirect('/login');
    }

    /**
     * Tamu tidak dapat menyimpan buku baru.
     */
    public function test_tamu_tidak_dapat_menyimpan_buku(): void
    {
        $response = $this->post('/buku', [
            'judul' => 'Buku Baru',
            'penulis' => 'Penulis Baru',
            'kategori' => 'Fiksi',
            'penerbit' => 'Penerbit Baru',
            'tahun_terbit' => 2024,
        ]);

        $response->assertRedirect('/login');
        $this->assertDatabaseMissing('buku', ['judul' => 'Buku Baru']);
    }

    /**
     * Admin dapat menambahkan buku baru lengkap dengan kategori dan penerbit.
     */
    public function test_admin_dapat_menambahkan_buku_baru(): void
    {
        $response = $this->actingAs($this->admin)->post('/buku', [
            'judul' => 'Negeri 5 Menara',
            'penulis' => 'Ahmad Fuadi',
            'kategori' => 'Fiksi Inspiratif',
            'penerbit' => 'Gramedia Pustaka Utama',
            'tahun_terbit' => 2009,
            'sinopsis' => 'Man Jadda Wajada.',
        ]);

        $response->assertRedirect('/buku');
        $response->assertSessionHas('sukses');

        $this->assertDatabaseHas('buku', [
            'judul' => 'Negeri 5 Menara',
            'penulis' => 'Ahmad Fuadi',
            'kategori' => 'Fiksi Inspiratif',
            'penerbit' => 'Gramedia Pustaka Utama',
        ]);
    }

    /**
     * Admin dapat memperbarui data buku.
     */
    public function test_admin_dapat_memperbarui_buku(): void
    {
        $buku = Buku::create([
            'judul' => 'Judul Lama',
            'penulis' => 'Penulis Lama',
            'kategori' => 'Kategori Lama',
            'penerbit' => 'Penerbit Lama',
            'tahun_terbit' => 2010,
        ]);

        $response = $this->actingAs($this->admin)->put('/buku/'.$buku->id, [
            'judul' => 'Judul Baru Diperbarui',
            'penulis' => 'Penulis Baru',
            'kategori' => 'Kategori Baru',
            'penerbit' => 'Penerbit Baru',
            'tahun_terbit' => 2021,
            'sinopsis' => 'Sinopsis baru.',
        ]);

        $response->assertRedirect('/buku/'.$buku->id);
        $response->assertSessionHas('sukses');

        $this->assertDatabaseHas('buku', [
            'id' => $buku->id,
            'judul' => 'Judul Baru Diperbarui',
            'kategori' => 'Kategori Baru',
            'penerbit' => 'Penerbit Baru',
        ]);
    }

    /**
     * Admin dapat menghapus buku.
     */
    public function test_admin_dapat_menghapus_buku(): void
    {
        $buku = Buku::create([
            'judul' => 'Buku Dihapus',
            'penulis' => 'Penulis',
            'kategori' => 'Fiksi',
            'penerbit' => 'Penerbit',
            'tahun_terbit' => 2015,
        ]);

        $response = $this->actingAs($this->admin)->delete('/buku/'.$buku->id);

        $response->assertRedirect('/buku');
        $response->assertSessionHas('sukses');

        $this->assertDatabaseMissing('buku', ['id' => $buku->id]);
    }

    /**
     * Validasi berbahasa Indonesia muncul jika input tidak sesuai aturan.
     */
    public function test_validasi_bahasa_indonesia(): void
    {
        $response = $this->actingAs($this->admin)->post('/buku', [
            'judul' => '',
            'penulis' => '',
            'kategori' => '',
            'penerbit' => '',
            'tahun_terbit' => 'bukan-angka',
        ]);

        $response->assertSessionHasErrors([
            'judul' => 'Judul buku wajib diisi.',
            'penulis' => 'Nama penulis wajib diisi.',
            'kategori' => 'Kategori buku wajib diisi.',
            'penerbit' => 'Nama penerbit wajib diisi.',
            'tahun_terbit' => 'Tahun terbit harus berupa angka.',
        ]);

        // Uji tahun melebihi tahun sekarang
        $responseMasaDepan = $this->actingAs($this->admin)->post('/buku', [
            'judul' => 'Buku Masa Depan',
            'penulis' => 'Penulis',
            'kategori' => 'Fiksi',
            'penerbit' => 'Penerbit',
            'tahun_terbit' => (int) date('Y') + 10,
        ]);

        $responseMasaDepan->assertSessionHasErrors(['tahun_terbit']);
    }

    /**
     * Fitur pencarian buku berdasarkan judul, penulis, kategori, atau penerbit.
     */
    public function test_pencarian_buku(): void
    {
        Buku::create([
            'judul' => 'Belajar Pemrograman Laravel',
            'penulis' => 'Taylor Otwell',
            'kategori' => 'Teknologi',
            'penerbit' => 'Informatika',
            'tahun_terbit' => 2023,
        ]);

        Buku::create([
            'judul' => 'Sejarah Peradaban Kuno',
            'penulis' => 'John Doe',
            'kategori' => 'Sejarah',
            'penerbit' => 'Pustaka Bangsa',
            'tahun_terbit' => 2020,
        ]);

        // Cari berdasarkan judul
        $resJudul = $this->get('/buku?cari=Laravel');
        $resJudul->assertSee('Belajar Pemrograman Laravel');
        $resJudul->assertDontSee('Sejarah Peradaban Kuno');

        // Cari berdasarkan kategori
        $resKategori = $this->get('/buku?cari=Teknologi');
        $resKategori->assertSee('Belajar Pemrograman Laravel');
        $resKategori->assertDontSee('Sejarah Peradaban Kuno');

        // Cari berdasarkan penerbit
        $resPenerbit = $this->get('/buku?cari=Informatika');
        $resPenerbit->assertSee('Belajar Pemrograman Laravel');
        $resPenerbit->assertDontSee('Sejarah Peradaban Kuno');
    }

    /**
     * Pagination membatasi 5 buku per halaman.
     */
    public function test_pagination_lima_buku_per_halaman(): void
    {
        for ($i = 1; $i <= 7; $i++) {
            Buku::create([
                'judul' => "Buku Nomor {$i}",
                'penulis' => "Penulis {$i}",
                'kategori' => 'Kategori Umum',
                'penerbit' => 'Penerbit Umum',
                'tahun_terbit' => 2020,
            ]);
        }

        $response = $this->get('/buku');
        $response->assertStatus(200);

        // Halaman 1 menampilkan 5 buku
        $this->assertEquals(5, $response->viewData('daftarBuku')->count());
        $this->assertEquals(7, $response->viewData('daftarBuku')->total());
    }
}
