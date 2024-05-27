<?php

namespace App\Http\Livewire\Order;

use App\Models\Company;
use App\Models\Order;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Add extends Component
{
    use AuthorizesRequests;
    public $modalActionVisible = false;
    public $type;
    public $entity;
    public $model;
    public $source;
    public $customer;
    public $customer_id;
    public $name;

    public function mount()
    {
        $this->customer = User::noadmin()->get();
    }

    public function rules()
    {
        return [
            'type' => 'required',
            'entity' => 'required',
        ];
    }

    public function create()
    {

        Order::create($this->modelData());
        $this->modalActionVisible = false;
        $this->resetForm();
        $this->emit('refreshLivewireDatatable');
    }

    public function modelData()
    {
        $data = [

            'type'          => 'selling',
            'name'          => $this->name,
            'entity_party'  => $this->entity,
            'status'        => 'draft',
            'customer_id' => $this->customer_id,
            'user_id'       => Auth::user()->id,
        ];
        if ($this->model && $this->source) {
            $data['source']      = $this->model;
            $data['source_id']   = $this->source;
        }
        return $data;
    }

    public function resetForm()
    {
        $this->type = null;
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
        if ((Auth::user()->super->first() && Auth::user()->super->first()->role == 'superadmin') || (Auth::user()->activeRole)) {
            return Company::where('user_id', 0)->get();
        }
        return Company::where('user_id', Auth::user()->id)->get();
    }

    public function render()
    {
        return view('livewire.order.add', [
            'companies' => $this->readCompany()
        ]);
    }
}
