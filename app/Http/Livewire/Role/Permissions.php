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
        $this->authorize('UPDATE_ROLE', 'ROLE');
        if ($this->role->permission()->find($id)) {
            $old = $this->role->permission()->find($id);
            $this->role->permission()->detach($id);
            addLog($this->role, $this->role->permission()->find($id), $old);
            $this->request[$id] = false;
        } else {
            $old = $this->role->permission()->find($id);
            $this->role->permission()->attach($id);
            addLog($this->role, $this->role->permission()->find($id), $old);
            $this->request[$id] = true;
        }

        $this->getPermission();
        $this->emit('saved');
    }

    public function checkAll()
    {
        $this->authorize('UPDATE_ROLE', 'ROLE');

        $this->role->permission()->attach($this->permission);
        foreach ($this->permission as $per) {

            addLog($this->role, $this->role->permission()->find($per->id));
        }

        $this->emit('checked');
    }

    public function unCheckAll()
    {
        $this->authorize('UPDATE_ROLE', 'ROLE');
        foreach ($this->permission as $per) {

            addLog($this->role, null, $this->role->permission()->find($per->id));
        }
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
