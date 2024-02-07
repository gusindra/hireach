<?php

namespace App\Http\Livewire\Setting;

use Livewire\Component; 

class DarkMode extends Component
{
    public $mode;

    public function mount()
    {
        // dd($this->mode);
    }

    public function updateChatTeam(){
        $this->emit('saved');
    }

    public function render()
    {
        return view('livewire.setting.dark-mode');
    }
}
