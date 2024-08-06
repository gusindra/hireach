<?php

namespace App\Http\Livewire\Role;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Events\DatabaseRefreshed;
use Illuminate\Support\Arr;

class Permissions extends Component
{
    use AuthorizesRequests;
    public $permission;
    public $role;
    public $request = [];

    public function mount($id)
    {
        $this->permission = Permission::get();
        $this->role = Role::find($id);
        $this->getPermission();
    }

    private function getPermission()
    {

        foreach ($this->role->permission()->get() as $permission) {
            $this->request[$permission->id] = true;
        }
    }

    public function check($id)
    {
        $this->authorize('CREATE_ROLE', 'ROLE');
        if ($this->role->permission()->find($id)) {
            $this->role->permission()->detach($id);
            // Arr::except($this->request,[$id]);
            $this->request[$id] = false;
            // unset($this->request[$id]);
        } else {
            $this->role->permission()->attach($id);
            // $newCompete = array($id=>true);
            // array_push($this->request, $newCompete);
            $this->request[$id] = true;
        }
        $this->getPermission();
        $this->emit('saved');
    }

    public function checkAll()
    {
        $this->authorize('UPDATE_ROLE', 'ROLE');
        $this->role->permission()->attach($this->permission);
        $this->emit('checked');
    }

    public function unCheckAll()
    {
        $this->authorize('UPDATE_ROLE', 'ROLE');
        $this->role->permission()->detach($this->permission);

        foreach ($this->request as $key => $value) {
            $this->request[$key] = false;
        }

        $this->emit('unchecked');
    }



    public function updatePermission()
    {
        $this->getPermission();
    }


    /**
     * The read function.
     *
     * @return void
     */
    public function read()
    {
        return $this->role->permission()->get();
    }

    public function render()
    {
        // dd($this->request);
        return view('livewire.role.permission', [
            'active' => $this->read(),
            'array' => json_encode($this->request)
        ]);
    }
}
