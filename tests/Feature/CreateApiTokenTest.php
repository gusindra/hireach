<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Http\Livewire\ApiTokenManager;
use Laravel\Sanctum\PersonalAccessToken;
use Livewire\Livewire;
use Tests\TestCase;

class CreateApiTokenTest extends TestCase
{
    // use RefreshDatabase;

    public function test_api_tokens_can_be_created()
    {
        if (!Features::hasApiFeatures()) {
            return $this->markTestSkipped('API support is not enabled.');
        }

        if (Features::hasTeamFeatures()) {
            $this->actingAs($user = User::find(1));
        } else {
            $this->actingAs($user = User::find(2));
        }

        Livewire::test(ApiTokenManager::class)
            ->set(['createApiTokenForm' => [
                'name' => 'Test Token',
                'permissions' => [
                    'read',
                    'update',
                ],
            ]])
            ->call('createApiToken');
        $token = $user->fresh()->tokens->first();
        $this->assertCount(1, $user->fresh()->tokens);
        $this->assertEquals('Test Token', $user->fresh()->tokens->first()->name);
        $this->assertTrue($user->fresh()->tokens->first()->can('read'));
        $this->assertFalse($user->fresh()->tokens->first()->can('delete'));



        $token->delete();
        $this->assertNull($user->fresh()->tokens->first());
    }
}
