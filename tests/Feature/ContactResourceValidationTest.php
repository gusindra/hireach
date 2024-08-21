<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactResourceValidationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_render_index_page()
    {
        $response = $this->actingAs(User::find(2))->$this->get('/contact-validation');

        $response->assertStatus(200);
    }
}
