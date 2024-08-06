<?php

namespace Tests\Feature;

use Illuminate\Support\Str;
use App\Models\BillingUser;
use App\Models\Client;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ContactTest extends TestCase
{

    /** @test */
    public function can_create_contact()
    {
        $user = User::find(2);

        Livewire::actingAs($user)
            ->test('contact.add')
            ->set('input.title', 'Mr.')
            ->set('input.name', 'John Doe')
            ->set('input.email', 'john@example.com')
            ->set('input.phone', '123456789')
            ->call('create');

        $this->assertDatabaseHas('clients', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '123456789',
        ]);
    }





    public function test_can_update_contact()
    {

        $user = User::find(2);

        $client = Client::latest()->first();

        Livewire::actingAs($user)
            ->test('contact.profile', ['user' => $client->id])
            ->set('inputuser.name', 'John Doe Updated')
            ->set('inputuser.email', 'john@example.com')
            ->set('inputuser.phone', '987654321')
            ->call('saveUser', $client->id)
            ->assertEmitted('user_saved');

        // Assert the database has the updated client data
        $this->assertDatabaseHas('clients', [
            'id' => $client->id,
            'name' => 'John Doe Updated',
            'email' => 'john@example.com',
            'phone' => '987654321',
        ]);
    }


    public function test_can_delete_contact()
    {
        $user = User::find(2);
        $client = Client::latest()->first();
        Livewire::actingAs($user)
            ->test('contact.delete', ['contactId' => $client->id])
            ->call('confirmDelete', $client->id)
            ->call('delete');
        $this->assertDatabaseMissing('clients', ['id' => $client->id]);
    }

    public function test_validation_create_contact()
    {
        $user = User::find(2);

        Livewire::actingAs($user)
            ->test('contact.add')
            ->set('input.title', '')
            ->call('create')
            ->assertHasErrors(['input.title' => ['required']]);

        Livewire::actingAs($user)
            ->test('contact.add')
            ->set('input.name', '')
            ->call('create')
            ->assertHasErrors(['input.name' => ['required']]);


        Livewire::actingAs($user)
            ->test('contact.add')
            ->set('input.email', 'ererer')
            ->call('create')
            ->assertHasErrors(['input.email' => ['email']]);
    }
}
