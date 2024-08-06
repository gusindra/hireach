<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Http\Livewire\UpdateProfileInformationForm;
use Livewire\Livewire;
use Tests\TestCase;

class ProfileInformationTest extends TestCase
{
    // use RefreshDatabase;

    public function test_current_profile_information_is_available()
    {
        $this->actingAs($user = User::find(2));

        $component = Livewire::test(UpdateProfileInformationForm::class);

        $this->assertEquals($user->name, $component->state['name']);
        $this->assertEquals($user->email, $component->state['email']);
    }

    public function test_profile_information_can_be_updated()
    {
        $this->actingAs($user = User::find(3));

        Livewire::test(UpdateProfileInformationForm::class)

            ->set('state.nick', 'lulu')
            ->set('state.phone_no', 90998787)

            ->call('updateProfileInformation', 'update');

        $this->assertEquals('lulu', $user->fresh()->nick);
        $this->assertEquals('90998787', $user->fresh()->phone_no);
    }
}
