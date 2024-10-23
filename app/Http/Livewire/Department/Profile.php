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
    public $clients = [];

    public function mount($departmentId)
    {
        $this->department = Department::findOrFail($departmentId);
        $this->source_id = $this->department->source_id;
        $this->name = $this->department->name;
        $this->ancestors = $this->department->ancestors;
        $this->parent = $this->department->parent;
        $this->server = $this->department->server;
        $this->client_id = $this->department->client_id;
        $this->clientSearch = $this->department->client->name ?? $this->department->client->phone ?? '';
    }

    protected $rules = [
        'source_id' => 'required|string|max:100',
        'name' => 'required|string|max:100',
        'ancestors' => 'required|string|max:50',
        'parent' => 'required|string|max:50',
        'server' => 'required|string|max:100',
        'client_id' => 'required|exists:clients,id',
    ];

    public function updatedClientSearch()
    {
        $cacheKey = 'clientDepartmentCache_' . md5($this->clientSearch);

        $this->clients = cache()->remember($cacheKey, 600, function () {
            return Client::where(function($query) {
                $query->where('name', 'like', '%' . $this->clientSearch . '%')
                      ->orWhere('phone', 'like', '%' . $this->clientSearch . '%');
            })
            ->limit(5)
            ->get();
        });
    }

    public function selectClient($id)
    {
        $client = Client::find($id);
        $this->client_id = $client->id;
        $this->clientSearch = $client->name ?? ($client->phone ?? null);
        $this->clients = [];
    }

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
