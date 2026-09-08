<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->get('/')->assertStatus(200)->assertSee('PHIM MỚI CẬP NHẬT');
        $this->get('/movies')->assertStatus(200)->assertSee('Kho phim');
    }
}
