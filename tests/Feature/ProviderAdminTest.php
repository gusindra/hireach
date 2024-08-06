<?php

namespace Tests\Feature;

use App\Http\Livewire\Provider\Add;
use App\Http\Livewire\Provider\Edit;
use App\Http\Livewire\User\AddProvider;
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



    public function test_can_delete_provider()
    {
        $user = User::find(1);
        $provider = Provider::where('code', 'ABC')->latest()->first();
        Livewire::actingAs($user)->test(Edit::class, ['uuid' => $provider->id])
            ->call('delete');

        $this->assertDatabaseMissing('providers', ['id' => $provider->id]);
    }

    public function test_it_can_add_and_delete_provider_for_user()
    {
        //Add
        $user = User::find(1);
        $provider = Provider::create([
            'name' => 'Test Provider',
            'code' => 'LALA',
            'channel' => 'email,sms',
        ]);


        Livewire::actingAs($user)->test(AddProvider::class, ['user' => $user])
            ->set('input.provider_id', $provider->id)
            ->set('input.channel', 'email')
            ->call('addProvider')
            ->assertEmitted('added');


        $this->assertDatabaseHas('provider_user', [
            'user_id' => $user->id,
            'provider_id' => $provider->id,
            'channel' => 'EMAIL',
        ]);
        //Delete
        $providerUser = ProviderUser::where('channel', 'email')->latest()->first();
        Livewire::actingAs($user)->test('user.add-provider', ['user' => $user])
            ->call('deleteShowModal', $providerUser->id)
            ->call('delete');

        $this->assertDatabaseMissing('provider_user', [
            'id' => $providerUser->id,
        ]);

        $provider->delete();
    }
}
