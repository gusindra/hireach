<?php

namespace App\Http\Livewire\Permission;

use App\Models\Permission;
use Livewire\Component;

class Delete extends Component
{
    public $permission;

    public function mount($permission)
    {
        $this->permission = $permission;
    }

    public function deletePermission($id)
    {
        $permission = Permission::find($id);
        if ($permission) {
            $permission->delete();
        }
    }



    public function render()
    {
        return view('livewire.permission.delete');
    }
}
