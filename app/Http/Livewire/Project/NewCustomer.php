<?php

namespace App\Http\Livewire\Project;

use App\Models\BillingUser;
use App\Models\Client;
use App\Models\Team;
use App\Models\User;
use Laravel\Jetstream\Jetstream;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Jetstream\Events\AddingTeam;
use App\Models\Project;

class NewCustomer extends Component
{
    public $modalActionVisible = false;
    public $input;
    public $inputclient;
    public $entity;
    public $model;
    public $source;
    public $showClients = false;
    public $is_modal = true;
    public $project;
    public $templateId;
    public $name;
    public $status;
    public $type;
    public $roleId;

    public function mount($uuid)
    {
        $this->project = Project::find($uuid);
        $this->name = $this->project->name;
        $this->roleId = $this->project->id;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'status' => 'required',
            'entity' => 'required',
            'type' => 'required',
        ];
    }

    public function projectData()
    {
        return [
            'name'                  => $this->name,
            'status'                => $this->status,
            'entity_party'          => $this->entity,
            'type'                  => $this->type
        ];
    }

    public function createFormUser()
    {
        dd(1);
        $customer =  Client::create([
            'title'     => $this->inputclient['title'],
            'name'      => $this->inputclient['name'],
            'phone'     => $this->inputclient['phone'],
            'address'   => $this->inputclient['address'],
            'note'      => $this->inputclient['notes'],
            'email'     => $this->inputclient['email'],
            'user_id'   => auth()->user()->id,
            'uuid'      => Str::uuid()
        ]);
        $team = Team::find(0);
        $customer->teams()->attach($team);
    }

    /**
     * Update Template
     *
     * @return void
     */
    public function update($id)
    {
        $this->validate();
        dd($id);
        //add new costumer
        $this->createFormUser();
        //save project title
        Project::find($id)->update($this->projectData());
        $this->emit('saved');
    }

    public function generatePassword()
    {
        $this->input['password'] = Str::random(8);
    }

    public function render()
    {
        return view('livewire.project.new-customer');
    }
}
