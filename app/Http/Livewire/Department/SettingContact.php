<?php

namespace App\Http\Livewire\Department;

use App\Models\Client;
use App\Models\Department;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Illuminate\Support\Str;

class SettingContact extends Component
{
    use AuthorizesRequests;
    public $modalActionVisible = false;
    public $selectDepartment;
    public $selectContact;
    public $new;
    public $input = [];
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
        $this->input['name'] = $value;
        $this->data = $client;
    }

    /**
     * updatedNew
     *
     * @param  mixed $value
     * @return void
     */
    public function updatedSelectContact()
    {
        $this->new = 0;
    }

    /**
     * updatedNew
     *
     * @param  mixed $value
     * @return void
     */
    public function updatedNew($value)
    {
        $this->selectContact = '';
        $result = $this->new = $value === "0" ? true : false;
        // dd($result);
    }

    /**
     * update
     *
     * @return void
     */
    public function update(){
        // dd($this->selectContact, $this->selectDepartment);
        // dd($this->input);
        // dd($this->new);
        //ADD NEW CONTACT IF NEW
        $dept = Department::find($this->selectDepartment);
        if($this->new==1){
            $client = Client::create([ 
                'name' => strip_tags(filterInput($this->input['name'])),
                'phone' => strip_tags(filterInput($this->input['phone'])),
                'email' => strip_tags(filterInput($this->input['email'])),
                'user_id' => $dept->user_id,
                'uuid' => Str::uuid()
            ]); 
            $this->selectContact = $client->id;
        }

        // UPDATE DEPARTMENT WITH CONTACT
        $dept->update(['client_id'=>$this->selectContact]);
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
