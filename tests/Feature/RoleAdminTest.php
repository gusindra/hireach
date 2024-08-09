<?php

namespace Tests\Feature;

use App\Http\Livewire\Role\Edit;
use App\Http\Livewire\Role\Member;
use App\Http\Livewire\Role\Permissions;
use App\Http\Livewire\Role\Roles;
use App\Http\Livewire\Table\Permission;
use App\Mail\RoleInvitation;
use App\Models\Permission as ModelsPermission;
use App\Models\Role;
use App\Models\RoleInvitation as ModelsRoleInvitation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class RoleAdminTest extends TestCase
{
    public function test_role_detail_can_be_rendered()
    {
        $user = User::find(1);
        $response = $this->actingAs($user)->get('admin/roles/1');

        $response->assertStatus(200);
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_create_role()
    {
        $user = User::find(1);

        Livewire::actingAs($user)->test(Roles::class)
            ->set('type', 'admin')
            ->set('name', 'Administrator')
            ->set('description', 'Administrator role')
            ->call('create')
            ->assertEmitted('refreshLivewireDatatable')
            ->assertSet('modalActionVisible', false)
            ->assertSet('type', null)
            ->assertSet('name', null)
            ->assertSet('description', null);


        $this->assertDatabaseHas('roles', [
            'type' => 'admin',
            'name' => 'Administrator',
            'description' => 'Administrator role',
            'team_id' => $user->current_team_id
        ]);
    }

    public function test_can_update_role()
    {
        $user = User::find(1);
        $role = Role::where('name', 'Administrator')->latest()->first();

        Livewire::actingAs($user)
            ->test(Edit::class, ['uuid' => $role->id])
            ->set('name', 'New Role Name')
            ->set('description', 'New Description')
            ->set('status', 'active')
            ->set('type', 'admin')
            ->set('role_for', 'general')
            ->call('update', $role->id)
            ->assertEmitted('saved');

        // Assert the role was updated
        $this->assertDatabaseHas('roles', [
            'id' => $role->id,
            'name' => 'New Role Name',
            'description' => 'New Description',
            'status' => 'active',
            'type' => 'admin',
            'role_for' => 'general',
        ]);
    }

    public function test_can_check_role_permission()
    {
        $user = User::find(1);
        $role = Role::where('name', 'New Role Name')->latest()->first();
        $permission = ModelsPermission::find(13);
        Livewire::actingAs($user)->test(Permissions::class, ['id' => $role->id])
            ->call('check', $permission->id)
            ->assertEmitted('saved');
        $role->refresh();

        // Assert the permission is attached
        $this->assertTrue($role->permission->contains($permission));
    }

    public function test_can_uncheck_role_permission()
    {
        $user = User::find(1);
        $role = Role::where('name', 'New Role Name')->latest()->first();
        $permission = ModelsPermission::find(13);

        // Test toggling the permission again to detach
        Livewire::actingAs($user)->test(Permissions::class, ['id' => $role->id])
            ->call('check', $permission->id)
            ->assertEmitted('saved');
        $role->refresh();

        // Assert the permission is detached
        $this->assertFalse($role->permission->contains($permission));
    }


    public function test_can_check_all_role_permission()
    {
        $user = User::find(1);
        $role = Role::where('name', 'New Role Name')->latest()->first();
        $permissions = ModelsPermission::find(13);

        Livewire::actingAs($user)->test(Permissions::class, ['id' => $role->id])
            ->call('checkAll')
            ->assertEmitted('checked');

        // Assert all permissions are attached
        $permissions->each(function ($permission) use ($role) {
            $this->assertTrue($role->permission->contains($permission));
        });
    }


    public function test_can_uncheck_all_role_permission()
    {
        $user = User::find(1);
        $role = Role::where('name', 'New Role Name')->latest()->first();
        $permissions = ModelsPermission::find(13);

        Livewire::actingAs($user)->test(Permissions::class, ['id' => $role->id])
            ->call('unCheckAll')
            ->assertEmitted('unchecked');

        // Assert all permissions are detached
        $permissions->each(function ($permission) use ($role) {
            $this->assertFalse($role->permission->contains($permission));
        });
    }


    public function test_can_add_email_intvitation()
    {
        $user = User::find(1);
        $role = Role::where('name', 'New Role Name')->latest()->first();


        // Test adding a role member
        Livewire::actingAs($user)->test(Member::class, ['id' => $role->id])
            ->set('inviteEmail', 'test@example.com')
            ->call('addRoleMember')
            ->assertEmitted('saved');

        // Assert the role invitation is created
        $this->assertDatabaseHas('role_invitations', [
            'email' => 'test@example.com',
            'role_id' => $role->id,
            'team_id' => $user->current_team_id
        ]);


        $this->assertDatabaseHas('log_changes', [
            'model' =>'Role',
            'model_id' =>  $role->id,
            'user_id'=>$user->id

        ]);

         $this->assertTrue(
            \DB::table('log_changes')
                ->where('model', 'Role')
                ->where('model_id', $role->id)
                ->where('user_id', $user->id)
                ->where('remark', 'like', '%New Role Name%')
                ->exists(),
            'The log entry does not contain the expected remark.'
        );
    }


    public function test_can_cancel_email_intvitation()
    {
        $user = User::find(1);
        $role = Role::where('name', 'New Role Name')->latest()->first();
        $invitation = ModelsRoleInvitation::where('email', 'test@example.com')->latest()->first();

        Livewire::actingAs($user)->test(Member::class, ['id' => $role->id])
         ->call('confirmCancelInvitation', $invitation->id)
            ->call('cancelTeamInvitation')
        ;

        // Assert the role invitation is deleted
        $this->assertDatabaseMissing('role_invitations', [
            'id' => $invitation->id,
            'email' => 'test@example.com',
            'role_id' => $role->id,
            'team_id' => $user->current_team_id
        ]);
    }

     public function test_a_user_can_remove_a_team_member()
    {
            $user = User::find(1);
        $role = Role::where('name', 'New Role Name')->latest()->first();
        $teamMember = User::factory()->create();



        Livewire::actingAs($user)->test(Member::class, ['id' => $role->id])
            ->call('confirmTeamMemberRemoval', $teamMember->id)
            ->call('removeTeamMember');

        $this->assertDatabaseMissing('role_user', [
            'role_id' => $role->id,
            'user_id' => $teamMember->id,
        ]);
    }
}
