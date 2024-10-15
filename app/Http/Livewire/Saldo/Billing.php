<?php

namespace App\Http\Livewire\Saldo;

use App\Models\BillingUser;
use App\Models\SaldoUser;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Billing extends Component
{
    use AuthorizesRequests;
    public $modalActionVisible = false;
    public $type;
    public $name;
    public $tax;
    public $province;
    public $city;
    public $postcode;
    public $address;
    public $user;
    public $billing;
    public $userId;


    public function mount($id)
    {
        $this->billing = BillingUser::where('user_id', $id)->latest()->first();
        if($this->billing){
            $this->user = $this->billing->user;
            $this->name = $this->billing->name;
            $this->tax = $this->billing->tax;
            $this->province = $this->billing->province;
            $this->city = $this->billing->city;
            $this->postcode = $this->billing->postcode;
            $this->address = $this->billing->address;
            $this->type = $this->billing->type;
        }
        $this->userId = $id;
    }


    public function rules()
    {
        if($this->type=='postpaid'){
            return [
                'type' => 'required',
                'name' => 'required',
                'tax' => 'required',
                'province' => 'required',
                'city' => 'required',
                'address' => 'required',
            ];
        }
        return [
            'type' => 'required',
        ];
    }


    public function create()
    {
        $this->validate();
        $billing = BillingUser::updateOrCreate($this->modelData());
        $this->modalActionVisible = false;
        return redirect(request()->header('Referer'));
    }


    public function modelData()
    {
        $data = [
            'name' => $this->name,
            'tax_id' => $this->tax,
            'post_code' => $this->postcode,
            'province' => $this->province,
            'city' => $this->city,
            'address' => $this->address,
            'user_id' => $this->userId,
            'type' => $this->type,
        ];
        return $data;
    }


    public function actionShowModal()
    {
        $this->authorize('UPDATE_USER', 'USER');
        $this->modalActionVisible = true;
    }

    public function render()
    {
        return view('livewire.saldo.billing');
    }
}
