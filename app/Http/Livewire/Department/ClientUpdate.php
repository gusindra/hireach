<?php

namespace App\Http\Livewire\Department;

use App\Models\Client;
use App\Models\Department;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Illuminate\Support\Str;

class ClientUpdate extends Component
{
    use AuthorizesRequests;

    public $modalActionVisible = false;
    public $selectDepartment;
    public $selectContact;
    public $selectAccount;
    public $new;
    public $input = [];
    public $search;
    public $contact;
    public $depts = [];
    public $data = [];
    public $users = [];
    public $isClient = true; // To differentiate between client and account
    public $showClients = false;
    public $is_modal = true;

    public function mount($model = null, $isClient = true)
    {
        $this->isClient = $isClient;

        if ($model != null) {
            $this->showClients = true;
        }
        $department = Department::find(request()->segment(3));
        $client = Client::find($department->client_id);
        if( $client){
            $clientSearch=   Client::where('name', 'like', '%' . $client->name . '%')

            ->orWhere('email', 'like', '%' . $client->email . '%')
            ->limit(5)
            ->get();

            $this->data = $clientSearch;
            $this->selectContact =  $client->id;
        }

        $account = User::find($department->account_id);
        if ($account) {
            $accountSearch = User::where('name', 'like', '%' . $account->name . '%')
                ->orWhere('email', 'like', '%' . $account->email . '%')
                ->limit(5)
                ->get();

            $this->users = $accountSearch;
            $this->selectAccount = $account->id;
        }


        if ($department) {
            $client = Department::where('id', $department->id)
                        ->orWhere('name', 'like', '%' . $department->name . '%')
                        ->limit(5)
                        ->get();
            $this->depts = $client;
            $this->selectDepartment = $department->id;
        }
    }

    public function updatedSearch($value)
    {
        if ($this->isClient) {
            $client = Client::where('name', 'like', '%' . $value . '%')
                        ->orWhere('phone', 'like', '%' . $value . '%')
                        ->orWhere('email', 'like', '%' . $value . '%')
                        ->limit(5)
                        ->get();
            $this->data = $client;
        } else {
            $user = User::where('name', 'like', '%' . $value . '%')
                        ->orWhere('email', 'like', '%' . $value . '%')
                        ->limit(5)
                        ->get();
            $this->users = $user;
        }
    }

    public function updatedContact($value)
    {
        $client = Client::where('name', 'like', '%' . $value . '%')
                    ->orWhere('phone', 'like', '%' . $value . '%')
                    ->orWhere('email', 'like', '%' . $value . '%')
                    ->limit(5)
                    ->get();
        $this->data = $client;
    }

    public function updatedSelectContact()
    {
        $this->new = 0;
    }

    public function updatedSelectAccount()
    {
        $this->new = 0;
    }

    public function updatedNew($value)
    {
        $this->selectContact = '';
        $this->new = $value === "0" ? true : false;
    }

    public function update()
    {
        $dept = Department::find($this->selectDepartment);

        if ($this->new == 1 && $this->isClient) {
            // Add new client
            $client = Client::create([
                'name' => strip_tags(filterInput($this->input['name'])),
                'phone' => strip_tags(filterInput($this->input['phone'])),
                'email' => strip_tags(filterInput($this->input['email'])),
                'user_id' => $dept->user_id,
                'uuid' => Str::uuid(),
            ]);
            $this->selectContact = $client->id;
        }

        if (!$this->isClient) {
            $dept->update(['account_id' => $this->selectAccount]);
            redirect(request()->header('Referer'));
        } else {
            $dept->update(['client_id' => $this->selectContact]);
            redirect(request()->header('Referer'));
        }

        $this->modalActionVisible = false;
        $this->resetForm();
        $this->emit('refreshLivewireDatatable');
    }

    public function resetForm()
    {
        $this->selectContact = null;
        $this->selectAccount = null;
        $this->selectDepartment = null;
        $this->search = null;
        $this->contact = null;
    }

    public function actionShowModal($isClient = true)
    {
        $this->isClient = $isClient;
        $this->modalActionVisible = true;
    }

    public function render()
    {
        return view('livewire.department.client-update');
    }
}
