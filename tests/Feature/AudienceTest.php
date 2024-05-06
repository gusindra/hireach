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


    public function test_can_add_contact_to_audience()
    {
        $client = Client::find(34);
        $audience = Audience::where('name', 'For Contact')->firstOrFail();

        Livewire::test(AddContact::class, ['audience' => $audience])
            ->set('contactId', $client->id)
            ->call('create');

        $this->assertDatabaseHas('audience_clients', [
            'client_id' => $client->uuid,
            'audience_id' => $audience->id,
        ]);
    }


    public function test_can_delete_audience_client()
    {

        $audienceClient = AudienceClient::latest()->first();
        Livewire::test(AddContact::class)
            ->set('actionId', $audienceClient->id)
            ->call('delete');

        $this->assertDatabaseMissing('audience_clients', [
            'id' => $audienceClient->id
        ]);
    }
}
