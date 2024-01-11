<?php

namespace App\Http\Livewire\Project;

use App\Models\Client;
use App\Models\Company;
use Livewire\Component;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Add extends Component
{
    use AuthorizesRequests;
    public $modalActionVisible = false;
    public $type;
    public $name;
    public $entity;
    public $customer='exists';
    public $customer_type;

    public function rules()
    {
        return [
            'type' => 'required',
            'name' => 'required',
            'entity' => 'required',
            'customer_type' => 'required',
        ];
    }

    public function create()
    {
        $this->authorize('create', new Project);
        $this->validate();
        Project::create($this->modelData());
        $this->modalActionVisible = false;
        $this->resetForm();
        $this->emit('refreshLivewireDatatable');
    }

    public function modelData()
    {
        // Need to find auth user with company id
        return [
            'type'          => $this->type,
            'name'          => $this->name,
            'entity_party'  => Auth::user()->currentTeam->id == 2 ? 0 : Auth::user()->currentTeam->id,
            'party_b'       => $this->entity,
            'team_id'       => !Auth::user()->currentTeam ? null : Auth::user()->currentTeam->id,
            'customer_type' => $this->customer=='exists' ? $this->customer_type:'new',
        ];
    }

    public function resetForm()
    {
        $this->type = null;
        $this->name = null;
        $this->entity = null;
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

    private function readCompany()
    {
        if((Auth::user()->super->first() && Auth::user()->super->first()->role == 'superadmin') || (Auth::user()->activeRole)){
            return Company::get();
        }
        return Company::where('user_id', Auth::user()->id)->get();
    }
    
    private function readCostumer()
    {
        return Client::where('user_id', Auth::user()->id)->get();
    }

    public function render()
    {
        return view('livewire.project.add', [
            'companies' => $this->readCostumer()
        ]);
    }
}
