<?php

namespace App\Http\Livewire\Template;

use App\Models\Template;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class Helper extends Component
{
    public $modalActionVisible = false;
    public $way = 2;
    public $type = 'helper';
    public $name;
    public $description;

    public function rules()
    {
        return [
            'type' => 'required',
            'name' => 'required',
            'description' => 'required',
        ];
    }

    public function create()
    {
        $this->validate();
        Template::create($this->modelData());
        $this->modalActionVisible = false;
        $this->resetForm();
        $this->emit('refreshLivewireDatatable');
    }

    public function modelData()
    {
        return [
            'uuid'          => Str::uuid(),
            'type'          => $this->type,
            'name'          => $this->name,
            'resource'      => $this->way == 2 ? $this->type : 'template',
            'description'   => $this->description,
            'user_id'       => Auth::user()->id,
        ];
    }

    public function resetForm()
    {
        $this->type = null;
        $this->name = null;
        $this->way = null;
        $this->description = null;
    }

    /**
     * createShowModal
     *
     * @return void
     */
    public function actionShowModalHelper()
    {
        $this->modalActionVisible = true;
    }

    public function render()
    {
        return view('livewire.template.helper');
    }
}
