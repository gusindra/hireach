<?php

namespace App\Http\Livewire\Team;

use Illuminate\Support\Facades\URL;
use Livewire\Component;
use Laravel\Jetstream\Jetstream;

class InviteTeamMemberForm extends Component
{
    public $email;
    public $role;
    public $showingInvitationLinkModal = false;
    public $invitationLink;
    public $copied = false;
    public $team;
    public $roles;
    protected $listeners = ['invitationDeleted' => 'refreshInvitations'];
    public function mount($team)
    {

        $this->team = $team;
        $allRoles = Jetstream::$roles;

        $this->roles = $this->organizeRoles($allRoles);

    }

    protected function organizeRoles($roles)
    {
        $organizedRoles = [
            'admin' => [],
            'agent' => []
        ];

        foreach ($roles as $role) {
            if (isset($role->key) && in_array($role->key, ['admin', 'agen'])) {
                $organizedRoles[$role->key][] = [
                    'key' => $role->key,
                    'name' => $role->name,
                    'description' => $role->description
                ];
            }
        }

        return $organizedRoles;
    }

    public function copyInvitationLink()
{
    $this->copied = true;
    $this->dispatchBrowserEvent('copySuccess');
}
        public function inviteTeamMember()
    {
        $this->validate([
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    if ($this->team->teamInvitations()->where('email', $value)->exists()) {
                        $fail(__('This email has already been invited to the team.'));
                    }
                }
            ],
            'role' => 'required|string|in:' . implode(',', array_column(array_merge(...array_values($this->roles)), 'key')),
        ]);

        $team = $this->team;

        $invitation = $team->teamInvitations()->create([
            'email' => $this->email,
            'role' => $this->role,
        ]);

        $this->invitationLink = URL::signedRoute('team-invitations.accept', [
            'invitation' => $invitation->id,
        ]);

        $this->showingInvitationLinkModal = true;

        $this->reset('email');
        $this->reset('role');
    }

    public function cancelTeamInvitation($invitationId)
    {
        $invitation = $this->team->teamInvitations()->find($invitationId);

        if ($invitation) {
            $invitation->delete();

        }
    }

    public function render()
    {
        return view('livewire.teams.invite-team-member-form',['team'=>$this->team]);
    }
}
