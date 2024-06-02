<?php

namespace App\Http\Livewire\Resource;

use Livewire\Component;

class Add extends Component
{
    public $modalActionVisible = false;
    public $showClients = false;
    public $is_modal = true;
    public $way;

    protected $listeners = ['resource_saved' => 'actionShowModal'];

    /**
     * mount
     *
     * @param  mixed $uuid
     * @return void
     */
    public function mount($way)
    {
        $this->way = $way;
    }

    /**
     * createShowModal
     *
     * @return void
     */
    public function actionShowModal()
    {
        $this->modalActionVisible = !$this->modalActionVisible;
    }

    /**
     * render
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.resource.add');
    }
}
