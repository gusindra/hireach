<?php

namespace App\Http\Livewire\Commercial\Item;

use App\Models\Warehouse;
use Livewire\Component;

class AddWarehouse extends Component
{
    public $modalActionVisible = false;
    public $type;
    public $name;
    public $code;
    public $address;
    public $user_id;
    public $status;

    public function rules()
    {
        return [
            'type' => 'required',
            'name' => 'required',
            'code' => 'required|unique:warehouse',
            'address' => 'required',
            'status' => 'required',
        ];
    }

    public function create()
    {
        $this->validate();
        Warehouse::create($this->modelData());
        $this->modalActionVisible = false;
        $this->resetForm();
        $this->emit('refreshLivewireDatatable');
    }

    public function modelData()
    {
        return [
            'name'      => $this->type,
            'code'      => $this->name,
            'address'   => $this->sku,
            'status'    => $this->price,
            'type'      => $this->price,
            'user_id'   => auth()->user()->id,
        ];
    }

    public function resetForm()
    {
        $this->name = null;
        $this->code = null;
        $this->address = null;
        $this->status = null;
        $this->type = null;
        $this->user_id = null;
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
        return view('livewire.commercial.item.add-warehouse');
    }
}
