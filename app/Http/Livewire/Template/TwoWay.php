<?php

namespace App\Http\Livewire\Template;

use App\Models\Template;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class TwoWay extends Component
{
    use AuthorizesRequests;
    public $modalActionVisible = false;
    public $way = 2;
    public $type;
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
        'uuid' => Str::uuid(),
        'type' => strip_tags(filterInput($this->way == 2 ? $this->type : 'text')),
        'name' => strip_tags(filterInput($this->name)),
        'resource' => strip_tags(filterInput($this->way)),
        'description' => strip_tags(filterInput($this->description)),
        'user_id' => Auth::user()->id,
    ];
}
    public function resetForm()
    {
        $this->type = null;
        $this->name = null;
        $this->description = null;
    }

    /**
     * createShowModal
     *
     * @return void
     */
    public function actionShowModalTwoWay()
    {
        $this->modalActionVisible = true;
    }

    public function render()
    {
        return view('livewire.template.two-way');
    }
}
