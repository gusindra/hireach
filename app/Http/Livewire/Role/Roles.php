<?php

namespace App\Http\Livewire\Role;


use Illuminate\Auth\Access\Gate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Roles extends Component
{
    use AuthorizesRequests;
    public $modalActionVisible = false;
    public $type;
    public $name;
    public $description;

    public function rules()
    {
        return [
            'type' => 'required',
            'name' => 'required',
            'description' => 'required',
        ];
    }

    public function create()
    {
        $this->authorize('CREATE_ROLE', 'ROLE');
        $this->validate();
        Role::create($this->modelData());
        addLog(Role::create($this->modelData()));
        $this->modalActionVisible = false;
        $this->resetForm();
        $this->emit('refreshLivewireDatatable');
    }

    public function modelData()
    {
        return [
            'type' => $this->type,
            'name' => $this->name,
            'description' => $this->description,
            'team_id' => Auth::user()->currentTeam->id,
        ];
    }

    public function resetForm()
    {
        $this->type = null;
        $this->name = null;
        $this->description = null;
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
        return view('livewire.role.add');
    }
}
