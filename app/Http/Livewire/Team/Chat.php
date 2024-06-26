<?php

namespace App\Http\Livewire\Team;

use App\Models\Team;
use Livewire\Component;
use Vinkla\Hashids\Facades\Hashids;

class Chat extends Component
{
    public $team;
    public $slug;
    public $dataId;
    public $modalActionVisible = true;

    public function mount($team)
    {
        $this->team = $team;
        $this->slug = $team->slug;
        $this->dataId = Hashids::encode($team->id);
        // dd($this->team);
    }

    public function updateChatTeam()
    {
        Team::find($this->team->id)->update(['slug' => $this->slug]);
        $this->emit('saved');
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

    public function render()
    {
        return view('livewire.team.chat');
    }
}
