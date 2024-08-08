<?php

namespace App\Http\Livewire\Audience;

use App\Models\Audience;
use Laravel\Jetstream\Jetstream;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Jetstream\Events\AddingTeam;

class Add extends Component
{
    public $modalActionVisible = false;
    public $input;
    public $inputclient;
    public $entity;
    public $model;
    public $source;
    public $showClients = false;
    public $is_modal = true;

    public function mount($model = null)
    {
        if ($model != null) {
            $this->showClients = true;
        }
    }

    public function rules()
    {
        return [
            'input.name'        => 'required|unique:audience,name',
            'input.description' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'input.name.unique' => 'The Audience Name has already been taken.',
        ];
    }

    public function create()
    {
        //dd(1);
        $this->validate();
        $customer =  Audience::create($this->modelData());
        return redirect(request()->header('Referer'));

        //$this->modalActionVisible = false;
        $this->resetForm();
        $this->emit('refreshLivewireDatatable');
    }

    public function generatePassword()
    {
        $this->input['password'] = Str::random(8);
    }

    public function modelData()
    {
        $data = [
            'name'          => strip_tags(filterInput($this->input['name'])),
            'description'   => strip_tags(filterInput($this->input['description'])),
            'user_id'      => auth()->user()->id,
        ];
        return $data;
    }

    public function resetForm()
    {
        $this->input = null;
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
        if ($this->is_modal == false) {
            return view('livewire.audience.form-add');
        }
        return view('livewire.audience.add');
    }
}
