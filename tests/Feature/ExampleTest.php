<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Memastikan halaman utama melakukan redirect ke rute katalog buku.
     */
    public function test_the_application_redirects_root_to_buku(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/buku');
    }
}
