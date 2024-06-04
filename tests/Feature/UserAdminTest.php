<?php

namespace Tests\Feature;

use App\Http\Livewire\Provider\Add;
use App\Http\Livewire\Provider\Edit;
use App\Http\Livewire\User\AddProvider;
use App\Http\Livewire\User\Delete;
use App\Models\Provider;
use App\Models\ProviderUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class UserAdminTest extends TestCase
{
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

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_create_a_user()
    {
        $user = User::find(1);
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
        $userLogin = User::find(1);
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

    public function test_it_creates_a_new_provider_user()
    {
        $user = User::find(1);
        $provider = Provider::find(2);
        Livewire::actingAs($user)->test('user.add-provider', ['user' => $user])
            ->set('input.providerId', $provider->id)
            ->set('input.channel', 'example-channel')
            ->call('addProvider')
            ->assertEmitted('added')
            ->assertSet('modalActionVisible', false);

        $this->assertDatabaseHas('provider_user', [
            'user_id' => $user->id,
            'provider_id' => 2,
            'channel' => 'example-channel',
        ]);
    }

    public function test_it_deletes_a_provider_user()
    {
        $user = User::find(1);

        $providerUser = ProviderUser::where('channel', 'example-channel')->latest()->first();
        Livewire::actingAs($user)->test(AddProvider::class, ['user' => $user])
            ->call('deleteShowModal', $providerUser->id)
            ->call('delete');

        $this->assertDatabaseMissing('provider_user', [
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

    public function test_it_deletes_user_and_redirects()
    {
        $userLogin = User::find(1);
        $user = User::where('email', 'updated@example.com')->latest()->first();
        Livewire::actingAs($userLogin)->test(Delete::class, ['userId' => $user->id])
            ->call('delete')
            ->assertRedirect(route('admin.user'));

        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }
}
