<?php

namespace App\Http\Livewire\Saldo;

use App\Models\SaldoUser;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Topup extends Component
{
    use AuthorizesRequests;
    public $modalActionVisible = false;
    public $team;
    public $currency;
    public $amount;
    public $description;
    public $user;
    public $mutation;
    public $saldoUser;
    public $userSaldo;
    public $userId;


    public function mount($id)
    {
        $saldoUser = SaldoUser::where('user_id', $id)->latest()->first();
        if ($saldoUser) {
            $this->saldoUser = $saldoUser;
        }

        $this->user = User::find($id);
    }


    public function rules()
    {
        return [
            'amount' => 'required',
            'currency' => 'required',
            'description' => 'required',
        ];
    }


    public function create()
    {
        $this->validate();
        $saldoUser = SaldoUser::create($this->modelData());
        addLog($saldoUser);
        $this->modalActionVisible = false;
        $this->resetForm();
        $this->saldoUser = $saldoUser;
        $this->emit('refreshLivewireDatatable');
    }


    public function modelData()
    {
        $data = [
            'team_id' => $this->team,
            'currency' => $this->currency,
            'amount' => $this->amount,
            'mutation' => $this->mutation,
            'description' => $this->description,
            'user_id' => $this->user->id,
        ];
        return $data;
    }

    public function resetForm()
    {
        $this->team_id = null;
        $this->currency = null;
        $this->amount = null;
        $this->mutation = null;
        $this->description = null;
    }

    public function actionShowModal()
    {

        $this->authorize('UPDATE_USER', 'USER');
        $this->modalActionVisible = true;
    }

    public function render()
    {
        return view('livewire.saldo.topup');
    }
}
