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

    public function test_users_can_leave_teams()
    {
        $user = User::factory()->create();
        $user->ownedTeams()->save($team = Team::factory()->make(['personal_team' => false]));

        $otherUser = User::factory()->create(['current_team_id' => $team->id]);
        $team->users()->attach($otherUser, ['role' => 'test-role']);


        $this->actingAs($otherUser);
        Livewire::test(TeamMemberManager::class, ['team' => $team])->call('leaveTeam');
        $otherUser->refresh();
        $this->assertCount(0, $team->fresh()->users()->where('users.id', $otherUser->id)->get());
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
