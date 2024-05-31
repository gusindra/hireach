<?php

namespace App\Http\Livewire\Team;

use App\Models\Client;
use Laravel\Jetstream\Jetstream;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Jetstream\Events\AddingTeam;

class Embed extends Component
{
    public $modalActionVisible = false;
    public $dataId;
    public $inputclient;
    public $entity;
    public $model;
    public $source;
    public $showClients = false;
    public $is_modal = true;

    public function mount($id)
    {
        $this->dataId = $id;
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
        return view('livewire.team.embed');
    }
}
