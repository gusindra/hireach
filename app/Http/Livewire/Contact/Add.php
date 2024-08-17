<?php

namespace App\Http\Livewire\Contact;

use App\Models\Client;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Laravel\Jetstream\Jetstream;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Jetstream\Events\AddingTeam;

class Add extends Component
{
    use AuthorizesRequests;
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
            'input.title' => 'required',
            'input.name' => 'required',
            'input.email' => 'email',
            'input.phone' => 'required',
        ];
    }

    public function create()
    {

        $this->validate();
        Client::create([
            'title' => strip_tags(filterInput($this->input['title'])),
            'name' => strip_tags(filterInput($this->input['name'])),
            'phone' => strip_tags(filterInput($this->input['phone'])),
            'email' => strip_tags(filterInput($this->input['email'])),
            'user_id' => auth()->user()->id,
            'uuid' => Str::uuid()
        ]);
        return redirect(request()->header('Referer'));
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


    public function render()
    {
        if ($this->is_modal == false) {
            return view('livewire.contact.form-add');
        }
        return view('livewire.contact.add');
    }
}
