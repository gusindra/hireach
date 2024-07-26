<?php

namespace App\Http\Livewire\Permission;

use App\Models\Permission;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Add extends Component
{
    use AuthorizesRequests;
    public $modalActionVisible = false;
    public $type;
    public $model;

    public function rules()
    {
        return [
            'type' => 'required',
            'model' => 'required',
        ];
    }

    public function create()
    {
        $this->authorize('CREATE_PERMISSION', 'PERMISSION');
        $this->validate();
        foreach ($this->type as $key => $menu) {
            Permission::create([
                'name' => strtoupper($key . ' ' . $this->model),
                'model' => strtoupper($this->model)
            ]);
        }
        $this->modalActionVisible = false;
        $this->resetForm();
        cache()->forget('permission-' . strtoupper($this->model));
        cache()->forget('permissions');
        $this->emit('refreshLivewireDatatable');
    }

    public function resetForm()
    {
        $this->type = null;
        $this->model = null;
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
        return view('livewire.permission.add');
    }
}
