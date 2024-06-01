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

class UserAdminTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_create_a_user()
    {
        $user = User::find(2);
        Livewire::actingAs($user)->test('user.add', ['role' => 'admin'])
            ->set('input', [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => 'secret123',
            ])
            ->call('createUser')
            ->assertHasNoErrors();

        $this->assertTrue(User::where('email', 'john@example.com')->exists());
    }

    public function test_it_can_update_a_user()
    {
        $userLogin = User::factory()->create();
        $user = User::where('name', 'John Doe')->latest()->first();
        Livewire::actingAs($userLogin)
            ->test('user.edit', ['userId' => $user->id])
            ->set('inputuser.name', 'Updated Name')
            ->set('inputuser.email', 'updated@example.com')
            ->set('inputuser.nick', 'UpdatedNick')
            ->set('inputuser.phone_no', '1234567890')
            ->call('updateUser', $user->id)
            ->assertEmitted('userSaved');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'nick' => 'UpdatedNick',
            'phone_no' => '1234567890',
        ]);
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

    public function test_it_can_create_a_provider_user()
    {
        $user = User::find(1);
        $provider = Provider::where('name', 'Test Provider')->latest()->first();

        Livewire::test('user.add-provider', ['user' => $user])
            ->set('providerId', $provider->id)
            ->set('channel', 'some_channel')
            ->call('create')
            ->assertEmitted('added');

        $this->assertDatabaseHas('provider_users', [
            'user_id' => $user->id,
            'provider_id' => $provider->id,
            'channel' => 'some_channel',
        ]);
    }

    public function test_it_can_delete_a_provider_user()
    {
        $user = User::find(1);
        $providerUser = ProviderUser::where('channel', 'some_channel')->latest()->first();

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

    public function test_can_delete_provider()
    {
        $user = User::find(1);
        $provider = Provider::where('code', 'ABC')->latest()->first();
        Livewire::actingAs($user)->test(Edit::class, ['uuid' => $provider->id])
            ->call('delete');

        $this->assertDatabaseMissing('providers', ['id' => $provider->id]);
    }
}
