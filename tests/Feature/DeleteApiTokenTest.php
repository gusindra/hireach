<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Http\Livewire\ApiTokenManager;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteApiTokenTest extends TestCase
{
    // use RefreshDatabase;

    public function test_api_tokens_can_be_deleted()
    {
        if (!Features::hasApiFeatures()) {
            return $this->markTestSkipped('API support is not enabled.');
        }
        $fakeName = Str::random(5);
        if (Features::hasTeamFeatures()) {
            $this->actingAs($user = User::find(2));
        } else {
            $this->actingAs($user = User::create([
                'name' => $fakeName,
                'email' => $fakeName.'@hireach.com',
                'password' => Hash::make('12345678'),
                'current_team_id' => 2
            ]));
        }

        $token = $user->tokens()->create([
            'name' => $fakeName,
            'token' => Str::random(40),
            'abilities' => ['create', 'read'],
        ]);

        Livewire::test(ApiTokenManager::class)
        ->set(['apiTokenIdBeingDeleted' => $token->id])
        ->call('deleteApiToken');

        $this->assertDatabaseMissing('personal_access_tokens', [
            'name' => $fakeName
        ]);
    }
}
