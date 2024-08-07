<?php

namespace App\Http\Livewire;

use App\Models\RoleUser;
use App\Models\Team;
use App\Models\TeamUser;
use Livewire\Component;

class SwitchTeam extends Component
{
    public $haveTeams = 0;
    /**
     * mount
     *
     * @return void
     */
    public function mount()
    {
        if(auth()->user()->listTeams){
            $this->haveTeams = count(auth()->user()->listTeams);
        }
    }

    /**
     * The update function.
     *
     * @return void
     */
    public function updateTeam($id)
    {
        //reset active RoleUser
        if(auth()->user()->activeRole){
            auth()->user()->activeRole->update([
                'active' => NULL
            ]);
        }

        $team = Team::find($id);
        $switch = auth()->user()->switchTeam($team);
        // dd($switch);
        //reset status TeamUser
        if($switch){
            TeamUser::where('user_id', auth()->user()->id)->update([
                'status' => NULL
            ]);
            $teamuser = TeamUser::where('team_id', empty(auth()->user()->currentTeam)?1:auth()->user()->currentTeam->id)->where('user_id', auth()->user()->id)->first();
            if($teamuser){
                $teamuser->update([
                    'status' => 'Online'
                ]);
            }
            session()->flash('message', 'Succsess switch team' );
            return redirect(request()->header('Referer'))->route('dashboard');
        }else{
            session()->flash('message', 'Sorry! You dont have authorize in to this team.' );
            return redirect(request()->header('Referer'))->route('dashboard');
        }
    }
    public function render()
    {
        return view('livewire.switch-team');
    }
}
