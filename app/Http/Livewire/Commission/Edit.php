<?php

namespace App\Http\Livewire\Commission;

use App\Models\Client;
use App\Models\CommerceItem;
use App\Models\Order;
use App\Models\Commision;
use App\Models\ProductLine;
use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use Livewire\Component;

class Edit extends Component
{
    public $model;
    public $master;
    public $clientId;
    public $type;
    public $selectedCleint;
    public $disabled;
    public $rate;
    public $status;
    public $total;
    public $commission;
    public $commisionId;


    public function mount($model, $data, $disabled = false)
    {

        $this->model = $model;
        if ($model == 'order') {
            $this->master = Order::find($data->id);
        } elseif ($model == 'project') {
            $this->master = Project::find($data->id);
        } elseif ($model == 'product') {
            $this->master = CommerceItem::find($data->id);
        }
        $this->commission = Commision::where('model', $this->model)->where('model_id', $data->id)->first();
        if ($this->commission) {
            $this->rate = $this->commission->ratio;
            $this->clientId = $this->commission->client_id;
            $this->type = $this->commission->type;
            $this->total = 'Rp' . number_format($this->commission->total);
        }
        $this->disabled = $disabled;
        $this->status = 'draft';
    }

    public function update($id)
    {
        $data = Commision::where('model', $this->model)->where('model_id', $id)->first();
        $oldData = $data ? $data->toArray() : null;

        if ($data) {
            $data->update([
                'type' => $this->type,
                'ratio' => $this->rate,
                'status' => $this->status,
                'client_id' => $this->clientId
            ]);
        } else {
            Commision::create([
                'model' => $this->model,
                'model_id' => $id,
                'type' => $this->type,
                'ratio' => $this->rate,
                'status' => $this->status,
                'client_id' => $this->clientId,
            ]);
        }

        $newData = Commision::where('model', $this->model)->where('model_id', $id)->first();


        $oldDataJson = $oldData ? json_encode($oldData) : null;

        addLog($newData, $oldDataJson);

        $this->emit('saved');
    }


    public function removeAgent()
    {

        Commision::destroy($this->commission->id);
        $this->rate = null;
        $this->clientId = null;
        $this->emit('removed');
    }

    public function read()
    {
        $sales = Role::where('name', 'LIKE', 'sales')->value('id');

        $data = User::whereHas('activeRole', function ($query) use ($sales) {
            $query->where('role_id', $sales);
        })->get();
        return $data;
    }

    public function data()
    {
        return Commision::where('model', $this->model)->where('model_id', $this->master->id)->first();
    }

    public function render()
    {
        return view('livewire.commission.edit', [
            'model_list' => $this->read(),
            'selected_agent' => $this->data()
        ]);
    }
}
