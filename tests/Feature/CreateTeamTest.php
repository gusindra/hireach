<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Http\Livewire\CreateTeamForm;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Support\Str;

class CreateTeamTest extends TestCase
{
      // use RefreshDatabase;

    public function test_teams_can_be_created()
    {
        $this->actingAs($user = User::find(3));
        $random = Str::random(8);
        Livewire::test(CreateTeamForm::class)
                    ->set(['state' => ['name' => $random]])
                    ->call('createTeam');

        $this->assertCount(2, $user->fresh()->ownedTeams);
        $this->assertEquals($random, $user->fresh()->ownedTeams()->latest('id')->first()->name);
        $user->fresh()->ownedTeams()->latest('id')->first()->delete();
    }
}
