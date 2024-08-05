<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Http\Livewire\DeleteUserForm;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteAccountTest extends TestCase
{
    // use RefreshDatabase;

    public function test_user_accounts_can_be_deleted()
    {
        if (!Features::hasAccountDeletionFeatures()) {
            return $this->markTestSkipped('Account deletion is not enabled.');
        }

        $this->actingAs($user = User::create([
            'name' => 'User Delete',
            'email' => 'uasesr1@hireach.com',
            'password' => Hash::make('12345678'),
            'current_team_id' => 0
        ]));

        $component = Livewire::test(DeleteUserForm::class)
            ->set('password', '12345678')
            ->call('deleteUser');
        $this->assertSoftDeleted('users', [
            'id' => $user->id,
        ]);

        $user->forceDelete();
    }

    public function test_correct_password_must_be_provided_before_account_can_be_deleted()
    {
        if (!Features::hasAccountDeletionFeatures()) {
            return $this->markTestSkipped('Account deletion is not enabled.');
        }

        $this->actingAs($user = User::factory()->create());

        Livewire::test(DeleteUserForm::class)
            ->set('password', 'wrong-password')
            ->call('deleteUser')
            ->assertHasErrors(['password']);

        $this->assertNotNull($user->fresh());
    }
}
