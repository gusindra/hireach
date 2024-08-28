<?php

namespace App\Http\Livewire\Contact;

use App\Models\BillingUser;
use App\Models\Client;
use App\Models\Department as ModelsDepartment;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Illuminate\Support\Str;

class Department extends Component
{
    use AuthorizesRequests;
    public $user;
    public $client;
    public $department;
    public $listDepartment;
    public $isadmin = false;

    /**
     * mount
     *
     * @param  mixed $client
     * @return void
     */
    public function mount($client)
    {
        $this->client = $client;
        $listDept = [];
        $list = $this->isadmin ? ModelsDepartment::whereNull('client_id')->get() : ModelsDepartment::where('user_id', $client->user_id)->get();
        foreach($list as $key => $l){
            $listDept[$key][0] = $l->id;
            $listDept[$key][1] = $l->source_id.':'.$l->name;
        }
        $this->listDepartment = $listDept;
    }

    /**
     * saveUser
     *
     * @param  mixed $id
     * @return void
     */
    public function saveDepartment()
    {
        ModelsDepartment::findOrFail($this->department)->update([
            'client_id' => $this->client->id
        ]);
        $this->emit('department_saved');
        return redirect(request()->header('Referer'));

    }

    /**
     * removeDepartment
     *
     * @param  mixed $this-
     * @return void
     */
    public function removeDepartment($id)
    {
        ModelsDepartment::findOrFail($id)->update([
            'client_id' => null
        ]);
        $this->emit('department_saved');
        return redirect(request()->header('Referer'));

    }

    public function render()
    {
        return view('livewire.contact.department', ['activeDepartment' => $this->client->department]);
    }
}
