<?php

namespace App\Http\Livewire\Permission;

use Livewire\Component;

class Delete extends Component
{
    public $permission;

    public function mount($permission)
    {
        $this->permission = $permission;
    }

    public function deletePermission()
    {
        $this->permission->delete();
        // You may add a success message or any other action upon successful deletion.
    }


    public function render()
    {
        return view('livewire.permission.delete');
    }
}
