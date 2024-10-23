<?php

namespace App\Http\Livewire\Department;

use App\Models\Department;
use App\Models\Client;
use Livewire\Component;

class Profile extends Component
{
    public $department;
    public $source_id;
    public $name;
    public $ancestors;
    public $parent;
    public $server;
    public $client_id;
    public $clientSearch = '';
    public $client;

    public function mount($departmentId)
    {
        $this->department = Department::findOrFail($departmentId);
        $this->source_id = $this->department->source_id;
        $this->name = $this->department->name;
        $this->ancestors = $this->department->ancestors;
        $this->parent = $this->department->parent;
        $this->server = $this->department->server;
        $this->client = $this->department->client->phone
        ?? $this->department->client->name
        ?? $this->department->client->email
        ?? null;

    }

    protected $rules = [
        'source_id' => 'required|string|max:100',
        'name' => 'required|string|max:100',
        'ancestors' => 'required|string|max:50',
        'parent' => 'required|string|max:50',
        'server' => 'required|string|max:100',

    ];



    public function update()
    {
        $this->validate();

        $this->department->update([
            'source_id' => $this->source_id,
            'name' => $this->name,
            'ancestors' => $this->ancestors,
            'parent' => $this->parent,
            'server' => $this->server,
            'client_id' => $this->client_id,
        ]);

        // Emit the 'departmentSaved' event
        $this->emit('departmentSaved');
    }

    public function render()
    {
        return view('livewire.department.profile');
    }
}
