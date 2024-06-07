<?php

namespace Tests\Feature;

use App\Http\Livewire\Audience\AddContact;
use App\Models\Audience;
use App\Models\AudienceClient;
use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class AudienceTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_create_audience()
    {
        $user = User::find(2);

        Livewire::actingAs($user)
            ->test('audience.add')
            ->set('input.name', 'Test Audience')
            ->set('input.description', 'This is a test audience.')
            ->call('create');

        $this->assertDatabaseHas('audience', [
            'name' => 'Test Audience',
            'description' => 'This is a test audience.',
            'user_id' => $user->id,
        ]);
    }


    public function test_can_update_audience()
    {

        $user = User::find(2);
        $audiences = Audience::where('name', 'Test Audience')->firstOrFail();

        Livewire::actingAs($user)
            ->test('audience.profile', ['user' => $audiences])
            ->set('inputuser.name', 'Test Audience1 Updated')
            ->set('inputuser.description', 'This is a test audience1. Updated')
            ->call('saveUser', $audiences->id)
            ->assertEmitted('user_saved');


        $this->assertDatabaseHas('audience', [
            'id' => $audiences->id,
            'name' => 'Test Audience1 Updated',
            'description' => 'This is a test audience1. Updated',
        ]);
    }


    public function test_can_delete_audience()
    {

        $user = User::find(2);
        $audience = Audience::where('name', 'Test Audience1 Updated')->firstOrFail();

        Livewire::actingAs($user)
            ->test('audience.delete')
            ->call('confirmDelete', $audience->id)
            ->call('delete');

        $this->assertDatabaseMissing('audience', ['id' => $audience->id]);
    }

    public function test_can_create_contact_for_audience()
    {

        $user = User::find(2);

        $audience = Audience::create([
            'input.name' => 'Test Audience',
            'input.description' => 'test desc',
            'user_id' => $user->id

        ]);

        Livewire::actingAs($user)
            ->test('contact.add')
            ->set('input.title', 'Mr.')
            ->set('input.name', 'John Doe')
            ->set('input.email', 'john@example.com')
            ->set('input.phone', '123456789')
            ->call('create');

        $client = Client::where('phone', '123456789')->latest()->first();

        Livewire::actingAs($user)
            ->test(AddContact::class, ['audience' => $audience])
            ->call('actionShowModal')
            ->set('contactId', $client->uuid)
            ->set('audienceId', $audience->id)

            ->call('create');


        $this->assertDatabaseHas('audience_clients', [
            'client_id' => $client->uuid,
            'audience_id' => $audience->id,
        ]);
    }


    public function test_can_delete_contact_at_audience()
    {

        $user = User::find(2);
        $audienceClient = AudienceClient::first();
        $audience = Audience::find(1);
        Livewire::actingAs($user)
            ->test(AddContact::class, ['audience' => $audience])
            ->call('deleteShowModal', $audienceClient->id)
            ->call('delete');

        $this->assertDatabaseMissing('audience_clients', ['id' => $audienceClient->id]);
    }
}
