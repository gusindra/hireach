<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Http\Livewire\TeamMemberManager;
use Livewire\Livewire;
use Tests\TestCase;

class UpdateTeamMemberRoleTest extends TestCase
{
    // use RefreshDatabase;

    public function test_team_member_roles_can_be_updated()
    {

        $this->actingAs($user = User::find(2));

        $otherUser = User::factory()->create(['current_team_id' => 2]);
        $user->currentTeam->users()->attach($otherUser, ['role' => 'admin']);

        Livewire::test(TeamMemberManager::class, ['team' => $user->currentTeam])
            ->set('managingRoleFor', $otherUser)
            ->set('currentRole', 'admin')
            ->call('updateRole');

        $otherUser = $otherUser->fresh();
        $currentTeam = $user->currentTeam->fresh();

        $this->assertTrue($otherUser->hasTeamRole(
            $currentTeam,
            'admin'
        ));
    }


    public function test_only_team_owner_can_update_team_member_roles()
    {
        $user = User::find(2);

        $user->currentTeam->users()->attach(
            $otherUser = User::find(3),
            ['role' => 'admin']
        );

        $this->actingAs($otherUser);

        $component = Livewire::test(TeamMemberManager::class, ['team' => $user->currentTeam])
            ->set('managingRoleFor', $otherUser)
            ->set('currentRole', 'editor')
            ->call('updateRole')
            ->assertStatus(403);

        $this->assertFalse($otherUser->fresh()->hasTeamRole(
            $user->currentTeam->fresh(),
            'admin'
        ));
    }
}
