<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_active_user_can_be_rendered()
    {
        $user = User::find(1);
        $response = $this->actingAs($user)->get('admin/dashboard/active-user');

        $response->assertStatus(200);
    }


    public function test_report_dashboard_can_be_rendered()
    {
        $user = User::find(1);
        $response = $this->actingAs($user)->get('admin/report');

        $response->assertStatus(200);
    }
}
