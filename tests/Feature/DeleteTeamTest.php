<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Jetstream\Http\Livewire\DeleteTeamForm;
use Laravel\Jetstream\Http\Livewire\TeamMemberManager;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteTeamTest extends TestCase
{
    // use RefreshDatabase;

    public function test_teams_can_be_deleted()
    {
        $this->actingAs($user = User::find(2));

        $user->ownedTeams()->save($team = Team::factory()->make([
            'personal_team' => false,
        ]));

        $team->users()->attach(
            $otherUser = User::create([
                'name' => 'User Delete Teams',
                'email' => 'ussesr1@hireach.com',
                'password' => Hash::make('12345678'),
                'current_team_id' => 2
            ]),
            ['role' => 'test-role']
        );

        $component = Livewire::test(DeleteTeamForm::class, ['team' => $team->fresh()])
            ->call('deleteTeam');

        $this->assertNull($team->fresh());
        $this->assertCount(0, $otherUser->fresh()->teams);
        $otherUser->forceDelete();
    }

    public function test_personal_teams_cant_be_deleted()
    {
        $this->actingAs($user = User::find(3));

        $user->ownedTeams()->save($team = Team::factory()->make([
            'personal_team' => true,
        ]));

        $team->users()->attach(
            $otherUser = User::create([
                'name' => 'User Cant Delete Teams',
                'email' => 'aaaa@hireach.com',
                'password' => Hash::make('12345678'),
                'current_team_id' => $team->id

            ]),
            ['role' => 'test-role']
        );

        $component = Livewire::test(TeamMemberManager::class, ['team' => $team])
            ->assertDontSeeLivewire('teams.delete-team-form');

        $otherUser->forceDelete();
        $team->forceDelete();
    }
}
