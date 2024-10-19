<?php

namespace App\Http\Livewire\Order;

use App\Models\Client;
use App\Models\Company;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Team;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Add extends Component
{
    use AuthorizesRequests;

    public $modalActionVisible = false;
    public $type='topup';
    public $entity;
    public $model;
    public $source;
    public $customer;
    public $customer_id;
    public $name;
    public $nominal;
    public $nominal_view;

    /**
     * mount
     *
     * @return void
     */
    public function mount()
    {
        $this->customer = User::noadmin()->get();
    }

    /**
     * rules
     *
     * @return void
     */
    public function rules()
    {
        return [
            'type' => 'required',
            'entity' => 'required_if:type,selling',
            'name' => 'required',
            'customer_id' => 'required',
        ];
    }

    /**
     * checkClient
     *
     * @return void
     */
    private function checkClient()
    {
        $client = User::find($this->customer_id);
        try {
            $customer = Client::where('email', $client->email)->where('user_id', 0)->firstOr(function () use ($client) {
                return Client::create([
                    'name' => $client->name,
                    'phone' => '00000',
                    'email' => $client->email,
                    'user_id' => 0,
                    'uuid' => Str::uuid()
                ]);
            });
            $team = Team::find(0);
            $customer->teams()->attach($team);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
        }
        return $customer->uuid;
    }

    /**
     * create
     *
     * @return void
     */
    public function create()
    {
        // $this->validate();
        $this->authorize('CREATE_ORDER', 'ORDER');
        $order = Order::create($this->modelData());
        $this->modalActionVisible = false;
        $this->resetForm();
        $this->emit('refreshLivewireDatatable');
    }

    /**
     * modelData
     *
     * @return void
     */
    public function modelData()
    {
        $data = [
            'type' => $this->type ?? 'topup',
            'name' => $this->name ?? 'Topup from Admin :  ' . Auth::user()->name,
            'entity_party' => $this->entity ?? '1',
            'no' => 'HAPP' . date("YmdHis"),
            'status' => 'draft',
            'customer_id' => $this->checkClient(),
            'user_id' => Auth::user()->id,
        ];
        if ($this->model && $this->source) {
            $data['source'] = $this->model;
            $data['source_id'] = $this->source;
        }
        return $data;
    }

    /**
     * resetForm
     *
     * @return void
     */
    public function resetForm()
    {
        $this->type = null;
        $this->entity = null;
        $this->name = null;
        $this->customer_id = null;
    }

    /**
     * actionShowModal
     *
     * @return void
     */
    public function actionShowModal()
    {
        $this->modalActionVisible = true;
    }

    /**
     * readCompany
     *
     * @return void
     */
    private function readCompany()
    {
        if ((Auth::user()->super->first() && Auth::user()->super->first()->role == 'superadmin') || (Auth::user()->activeRole)) {
            return Company::get();
        }
        return Company::where('user_id', Auth::user()->id)->get();
    }

    /**
     * onClickNominal
     *
     * @param  mixed $value
     * @return void
     */
    public function onClickNominal($value)
    {
        $this->nominal = $value;
        $this->nominal_view = number_format($value);
    }


    /**
     * render
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.order.add', [
            'companies' => $this->readCompany(),
        ]);
    }
}
