<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TeamUser;

class MenuSelection extends Component
{
    public $selection = ['Avaiable', 'Busy', 'Away', 'Offline'];
    public $menu;

    /**
     * mount
     *
     * @return void
     */
    public function mount($url)
    {
        $menu = explode('/', $url);
        $this->menu = $menu[3];
    }

    /**
     * The update function.
     *
     * @return void
     */
    public function updateMenu($menu)
    {
        $this->menu = $menu;
        $this->emit('saved');
    }

    public function render()
    {
        return view('livewire.menu-selection');
    }
}
