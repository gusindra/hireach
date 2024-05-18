<?php

namespace App\Http\Livewire\Provider;

use App\Models\Provider;
use Livewire\Component;

class Add extends Component
{
    public $modalActionVisible = false;
    public $code;
    public $name;

    public function rules()
    {
        return [
            'code' => 'required',
            'name' => 'required',

        ];
    }

    public function create()
    {
        $this->validate();
        Provider::create($this->modelData());
        $this->modalActionVisible = false;
        $this->resetForm();
        $this->emit('refreshLivewireDatatable');
    }

    public function modelData()
    {
        return [
            'code'          => strtoupper($this->code),
            'name'          => $this->name,

        ];
    }

    public function resetForm()
    {
        $this->code = null;
        $this->name = null;
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
        return view('livewire.provider.add');
    }
}
