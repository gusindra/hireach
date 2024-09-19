<?php

namespace App\Http\Livewire\Department;

use App\Models\Client;
use App\Models\Department;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class SettingContact extends Component
{
    use AuthorizesRequests;
    public $modalActionVisible = false;
    public $selectDepartment;
    public $selectContact;
    public $search;
    public $contact;
    public $depts = [];
    public $data = [];
    public $showClients = false;
    public $is_modal = true;

    public function mount($model = null)
    {
        if ($model != null) {
            $this->showClients = true;
        }
    }

    /**
     * updatedTemplateId
     *
     * @param  mixed $value
     * @return void
     */
    public function updatedSearch($value)
    {
        $client = Department::where('id', $value)->orWhere('name', 'like', '%' . $value . '%')->limit(5)->get();
        $this->depts = $client;
    }

    /**
     * updatedTemplateId
     *
     * @param  mixed $value
     * @return void
     */
    public function updatedContact($value)
    {
        $client = Client::where('id', $value)->orWhere('name', 'like', '%' . $value . '%')->orWhere('phone', 'like', '%' . $value . '%')->orWhere('email', 'like', '%' . $value . '%')->limit(5)->get();
        $this->data = $client;
    }

    /**
     * update
     *
     * @return void
     */
    public function update(){
        // dd($this->selectContact, $this->selectDepartment);
        Department::find($this->selectDepartment)->update(['client_id'=>$this->selectContact]);
        $this->modalActionVisible = false;
        $this->resetForm();
        $this->emit('refreshLivewireDatatable');
    }

    /**
     * resetForm
     *
     * @return void
     */
    public function resetForm()
    {
        $this->selectContact = null;
        $this->selectDepartment = null;
        $this->search = null;
        $this->contact = null;
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
        return view('livewire.department.search');
    }
}
