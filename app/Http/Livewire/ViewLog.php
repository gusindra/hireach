<?php

namespace App\Http\Livewire;

use App\Models\LogChange;
use Livewire\Component;

class ViewLog extends Component
{
    public $log_id;
    public $logs;
    public $modalActionVisible = false;

    public function mount($id, $model)
    {
        $this->log_id = $id;
        $this->logs = LogChange::where('model', $model)->where('model_id', $id)->get();
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
        return view('livewire.view-log');
    }
}
