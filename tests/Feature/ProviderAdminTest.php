<?php

namespace Tests\Feature;

use App\Http\Livewire\Provider\Add;
use App\Http\Livewire\Provider\Edit;
use App\Models\Provider;
use App\Models\ProviderUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ProviderAdminTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_render_page_provider()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $response = $this->get('admin/settings/providers');
        $response->assertStatus(200);
    }


    public function test_can_create_provider()
    {
        $user = User::find(1);
        Livewire::actingAs($user)->test(Add::class)
            ->set('code', 'ABC')
            ->set('name', 'Test Provider')
            ->call('create');

        $this->assertDatabaseHas('providers', [
            'code' => 'ABC',
            'name' => 'Test Provider',
        ]);
    }

    public function test_can_update_provider()
    {
        $user = User::find(1);
        $provider = Provider::where('code', 'ABC')->latest()->first();

        Livewire::actingAs($user)->test(Edit::class, ['uuid' => $provider->id])
            ->set('code', 'ABC')
            ->set('name', 'Updated Provider')
            ->call('update', $provider->id);

        $this->assertDatabaseHas('providers', [
            'id' => $provider->id,
            'code' => 'ABC',
            'name' => 'Updated Provider',
        ]);
    }

    public function test_can_delete_provider()
    {
        $user = User::find(1);
        $provider = Provider::where('code', 'ABC')->latest()->first();
        Livewire::actingAs($user)->test(Edit::class, ['uuid' => $provider->id])
            ->call('delete');

        $this->assertDatabaseMissing('providers', ['id' => $provider->id]);
    }

    public function test_it_can_delete_a_provider_user()
    {
        $user = User::factory()->create();
        $providerUser = ProviderUser::factory()->create([
            'user_id' => $user->id,
        ]);

        Livewire::test('user.add-provider', ['user' => $user])
            ->call('deleteShowModal', $providerUser->id)
            ->call('delete')
            ->assertEmitted('event-notification', [
                'eventName' => 'Deleted Page',
                'eventMessage' => 'The page (' . $providerUser->id . ') has been deleted!',
            ]);

        $this->assertDatabaseMissing('provider_users', [
            'id' => $providerUser->id,
        ]);
    }
}
