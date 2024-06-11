<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OderUserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_render_order__user()
    {
        $user = User::find(1);
        $response = $this->actingAs($user)->get('order');

        $response->assertStatus(200);
    }
}
