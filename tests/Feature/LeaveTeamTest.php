<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Jetstream\Http\Livewire\TeamMemberManager;
use Livewire\Livewire;
use Tests\TestCase;

class LeaveTeamTest extends TestCase
{
    // use RefreshDatabase;

    public function test_users_can_leave_teams()
    {
        $user = User::find(3);

        $user->ownedTeams()->save($team = Team::factory()->make([
            'personal_team' => false,
        ]));

        $team->users()->attach(
            $otherUser = User::create([
                'name' => 'User Can Leave Teams',
                'email' => 'hias@hireach.com',
                'password' => Hash::make('12345678'),
                'current_team_id' => $team->id

            ]),
            ['role' => 'test-role']
        );

        $this->actingAs($otherUser);

        $component = Livewire::test(TeamMemberManager::class, ['team' => $team])
            ->call('leaveTeam');
        dd(1);
        $otherUser->refresh();
        $this->assertCount(0, $user->currentTeam->fresh()->users);
    }

    public function test_team_owners_cant_leave_their_own_team()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $component = Livewire::test(TeamMemberManager::class, ['team' => $user->currentTeam])
            ->call('leaveTeam')
            ->assertHasErrors(['team']);

        $this->assertNotNull($user->currentTeam->fresh());
    }
}
