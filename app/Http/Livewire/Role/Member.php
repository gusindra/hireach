<?php


namespace App\Http\Livewire\Role;

use App\Mail\RoleInvitation as MailRoleInvitation;
use App\Models\RoleInvitation;
use App\Models\RoleUser;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;

class Member extends Component
{
    use AuthorizesRequests;
    public $team;
    public $role;
    public $inviteEmail;
    public $inviteCancel;
    public $confirmingTeamMemberRemoval = false;
    public $showCopyLinkModal = false;
    public $inviteLink;

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
        addLog($invitation);
        $this->inviteLink = URL::signedRoute('role-invitations.accept', [
            'invitation' => $invitation->id,
        ]);

        Log::debug($this->inviteLink);


        $this->showCopyLinkModal = true;

        $this->resetForm();

        $this->emit('saved');
    }

    public function resetForm()
    {
        $this->inviteEmail = null;
    }

    public function cancelTeamInvitation($id)
    {
        $this->authorize('DELETE_ROLE', 'ROLE');
        $this->inviteCancel = $id;
        $this->confirmingTeamMemberRemoval = true;
    }

    public function removeTeamMember()
    {
        $this->authorize('UPDATE_ROLE', 'ROLE');
        $old = RoleInvitation::find($this->inviteCancel);
        RoleInvitation::find($this->inviteCancel)->delete();
        addLog(null, $old);
        $this->confirmingTeamMemberRemoval = false;
        $this->inviteCancel = null;
        $this->emit('deleted');
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
