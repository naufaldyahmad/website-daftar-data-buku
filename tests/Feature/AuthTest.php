<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'name' => 'Admin Perpustakaan',
            'email' => 'admin@perpustakaan.test',
            'password' => Hash::make('password123'),
        ]);
    }

    /**
     * Halaman login dapat diakses oleh pengunjung tamu.
     */
    public function test_halaman_login_dapat_diakses(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Masuk Admin');
        $response->assertSee('admin@perpustakaan.test');
    }

    /**
     * Pengguna dapat login dengan kredensial yang benar.
     */
    public function test_admin_berhasil_login(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@perpustakaan.test',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/buku');
        $this->assertAuthenticatedAs($this->user);
    }

    /**
     * Login gagal jika password salah dan mengembalikan pesan error bahasa Indonesia.
     */
    public function test_login_gagal_dengan_password_salah(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@perpustakaan.test',
            'password' => 'passwordsalah',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    /**
     * Admin yang sudah login diarahkan ke halaman utama jika membuka form login lagi.
     */
    public function test_admin_terautentikasi_dialihkan_dari_halaman_login(): void
    {
        $response = $this->actingAs($this->user)->get('/login');

        $response->assertRedirect('/buku');
    }

    /**
     * Admin dapat melakukan logout.
     */
    public function test_admin_dapat_logout(): void
    {
        $response = $this->actingAs($this->user)->post('/logout');

        $response->assertRedirect('/buku');
        $this->assertGuest();
    }
}
