<?php

namespace App\Http\Livewire\Permission;

use App\Models\Permission;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Delete extends Component
{
    use AuthorizesRequests;
    public $permission;
    public $modalDeleteVisible = false;
    public $actionShowDeleteModal = false;

    public function mount($permission)
    {
        $this->permission = $permission;
    }

    public function delete($id)
    {
        $this->authorize('DELETE_PERMISSION', 'PERMISSION');
        $permission = Permission::find($id);
        cache()->forget('permissions');
        cache()->forget('permission-' . strtoupper($permission->model));
        if ($permission) {
            $permission->delete();
        }
        $this->modalDeleteVisible = false;
        $this->redirect('permission');
    }

    public function actionShowDeleteModal()
    {
        $this->modalDeleteVisible = true;
    }

    public function render()
    {
        return view('livewire.permission.delete');
    }
}
