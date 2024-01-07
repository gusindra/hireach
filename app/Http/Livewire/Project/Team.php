<?php

namespace App\Http\Livewire\Project;

use App\Models\Team as ModelsTeam;
use App\Models\TeamUser;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Gate;
use Laravel\Jetstream\Events\InvitingTeamMember;
use App\Mail\TeamInvitation as MailTeamInvitation;

class Team extends Component
{
    public $team;
    public $email;
    public $role='editor';
    public $message;
    public $user_id;
    public $modalActionVisible = false;

    public function mount($team_id)
    {
        $this->team = ModelsTeam::find($team_id);
    }

    public function read()
    {
        return $this->team;
    }

    public function render()
    {
        return view('livewire.project.team', [
            'team' => $this->read()
        ]);
    }

    public function rules()
    {
        return [
            'email' => 'required'
        ];
    }

    public function invite()
    {
        // dd($this->email);
        $this->validate();
        // if(auth()->user->team->role != 'admin' ){
        //     Gate::forUser(auth()->user)->authorize('addTeamMember', $this->team);
        // }

        // $this->validate($this->team, $this->email, $this->role);

        InvitingTeamMember::dispatch($this->team, $this->email, $this->role);

        $invitation = $this->team->teamInvitations()->create([
            'email' => $this->email,
            'role' => 'editor',
        ]);

        //Mail::to($this->email)->send(new MailTeamInvitation($invitation));
        $this->modalActionVisible = false;
        $this->resetForm();
    }

    public function modelData()
    {
        $data = [
            'email'     => $this->email,
            'team_id'   => $this->team->id,
            'user_id'   => $this->user_id,
            'role'      => 'editor',
        ];
        return $data;
    }

    public function resetForm()
    {
        $this->email = null;
        $this->user_id = null;
    }

    /**
     * createShowModal
     *
     * @return void
     */
    public function actionShowModal()
    {
        $this->modalActionVisible = true;
    }
}
