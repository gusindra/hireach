<?php

namespace App\Http\Livewire\Role;

use App\Models\RoleInvitation;
use App\Models\RoleUser;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Illuminate\Support\Facades\URL;

class Member extends Component
{
    use AuthorizesRequests;
    public $team;
    public $role;
    public $inviteEmail;
    public $confirmingInvitationCancel = false;
    public $confirmingTeamMemberRemoval = false;
    public $showCopyLinkModal = false;
    public $inviteLink;
    public $invitationIdBeingCanceled = null;
    public $teamMemberIdBeingRemoved = null;

    public function mount($id)
    {
        $this->role = $id;
    }

    public function addRoleMember()
    {
        $this->authorize('CREATE_ROLE', 'ROLE');
        $invitation = RoleInvitation::create([
            'email' => $this->inviteEmail,
            'role_id' => $this->role,
            'team_id' => auth()->user()->current_team_id
        ]);

        $this->inviteLink = URL::signedRoute('role-invitations.accept', [
            'invitation' => $invitation->id,
        ]);

        $this->showCopyLinkModal = true;

        $this->resetForm();

        $this->emit('saved');
    }

    public function resetForm()
    {
        $this->inviteEmail = null;
    }

    public function confirmCancelInvitation($id)
    {
        $this->authorize('DELETE_ROLE', 'ROLE');
        $this->invitationIdBeingCanceled = $id;
        $this->confirmingInvitationCancel = true;
    }

    public function cancelTeamInvitation()
    {
        $this->authorize('DELETE_ROLE', 'ROLE');

        $roleInvitation = RoleInvitation::find($this->invitationIdBeingCanceled);

        if ($roleInvitation) {
            $roleInvitation->delete();
            $this->emit('deleted');
        }

        $this->confirmingInvitationCancel = false;
        $this->invitationIdBeingCanceled = null;
    }

    public function confirmTeamMemberRemoval($userId)
    {
        $this->authorize('UPDATE_ROLE', 'ROLE');
        $this->teamMemberIdBeingRemoved = $userId;
        $this->confirmingTeamMemberRemoval = true;
    }

    public function removeTeamMember()
    {
        $this->authorize('UPDATE_ROLE', 'ROLE');

        $roleUser = RoleUser::find($this->teamMemberIdBeingRemoved);

        if ($roleUser) {
            $roleUser->delete();
            $this->emit('deleted');
        }

        $this->confirmingTeamMemberRemoval = false;
        $this->teamMemberIdBeingRemoved = null;
    }

    public function readInvite()
    {
        return RoleInvitation::where('role_id', $this->role)->get();
    }

    public function readUser()
    {
        return RoleUser::where('role_id', $this->role)->get();
    }

    public function render()
    {
        return view('livewire.role.member', [
            'invites' => $this->readInvite(),
            'users' => $this->readUser()
        ]);
    }
}
