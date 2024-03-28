<?php

namespace App\Http\Livewire\Contact;

use App\Models\Client;
use Laravel\Jetstream\Jetstream;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Jetstream\Events\AddingTeam;

class Import extends Component
{
    public $modalActionVisible = false;
    public $input;
    public $inputclient;
    public $entity;
    public $model;
    public $source;
    public $showClients = false;
    public $is_modal = true;

    public function mount($model=null)
    {
        if($model!=null){
            $this->showClients = true;
        }
    }

    public function rules()
    {
        return [
            'input.title'       => 'required',
            'input.name'        => 'required',
            'input.email'       => 'required',
            'input.phone'       => 'required',
            'input.province'    => 'required',
            'input.city'        => 'required',
        ];
    }

    public function create()
    {
        //dd(1);
        $this->validate();
        $customer =  Client::create([
            'title'     => $this->input['title'],
            'name'      => $this->input['name'],
            'phone'     => $this->input['phone'],
            'email'     => $this->input['email'],
            'province'  => $this->input['province'],
            'city'      => $this->input['city'],
            'user_id'   => auth()->user()->id,
            'uuid'      => Str::uuid()
        ]);
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
            'name' => $this->input['name'],
            'email' => $this->input['email'],
            'password' => Hash::make($this->input['password']),
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

    public function createFormUser()
    {
        dd(1);
    }

    public function render()
    {
        if($this->is_modal==false){
            return view('livewire.contact.form-add');
        }
        return view('livewire.contact.import');
    }
}
