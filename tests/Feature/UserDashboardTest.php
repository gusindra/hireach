<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserDashboardTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_render_overview()
    {
        $user = User::find(2);
        $response = $this->actingAs($user)->get('dashboard');
        $response->assertStatus(200);
    }

    public function test_render_inbound_with_filter()
    {
        $user = User::find(2);
        $response = $this->actingAs($user)->get('dashboard/inbound?filterMonth=2024-07');
        $response->assertStatus(200);
    }

    public function test_render_outbound_with_filter()
    {
        $user = User::find(2);
        $response = $this->actingAs($user)->get('dashboard/outbound?filterMonth=2024-07');
        $response->assertStatus(200);
    }
}
