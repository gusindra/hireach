<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Jetstream\Http\Livewire\TeamMemberManager;
use Livewire\Livewire;
use Tests\TestCase;

class RemoveTeamMemberTest extends TestCase
{

    public function test_team_members_can_be_removed_from_teams()
    {

        $user = User::find(2) ?? User::factory()->create(['id' => 2]);
        $otherUser = User::create([
            'name' => 'User Test',
            'email' => 'usertest1@hireach.com',
            'password' => Hash::make('12345678')
        ]);

        $team = $user->currentTeam ?? Team::factory()->create(['owner_id' => $user->id]);
        $team->users()->attach($otherUser, ['role' => 'admin']);
        $otherUser->current_team_id = $team->id;
        $otherUser->save();

        $this->actingAs($user);

        Livewire::test(TeamMemberManager::class, ['team' => $team])
            ->set('teamMemberIdBeingRemoved', $otherUser->id)
            ->call('removeTeamMember');


        $team->refresh();
        $this->assertFalse($team->users()->where('users.id', $otherUser->id)->exists());
        $otherUser->forceDelete();
    }

    public function test_only_team_owner_can_remove_team_members()
    {
        $this->actingAs($user = User::find(2));

        $user->currentTeam->users()->attach(
            $otherUser = User::create([
                'name' => 'User Test',
                'email' => 'usertest@hireach.com',
                'password' => Hash::make('12345678'),
                'current_team_id' => 0
            ]),
            ['role' => 'admin']
        );

        $this->actingAs($otherUser);

        $component = Livewire::test(TeamMemberManager::class, ['team' => $user->currentTeam])
            ->set('teamMemberIdBeingRemoved', $user->id)
            ->call('removeTeamMember')
            ->assertStatus(403);

        $otherUser->forceDelete();
    }
}
