<?php

namespace App\Http\Livewire\Setting\General\CommerceItem;

use Livewire\Component;
use App\Models\CommerceItem; // Import the CommerceItem model
use App\Models\ProductLine;
use Illuminate\Support\Facades\Auth; // Import Auth facade

class Add extends Component
{
    public $sku;
    public $name;
    public $spec;
    public $general_discount;
    public $fs_price;
    public $unit_price;
    public $product_line;
    public $productLine = [];

    public $modalActionVisible = false;

    protected $rules = [
        'sku' => 'required',
        'name' => 'required',
        'spec' => 'required',
        'general_discount' => 'required',
        'fs_price' => 'required',
        'unit_price' => 'required',
        'product_line' => 'required',
    ];

    public function mount()
    {
        $this->productLine = ProductLine::all();
    }
    public function actionShowModal()
    {
        $this->modalActionVisible = true;
    }

    public function create()
    {
        $this->validate();

        CommerceItem::create([
            'sku' => $this->sku,
            'name' => $this->name,
            'spec' => $this->spec,
            'general_discount' => $this->general_discount,
            'fs_price' => $this->fs_price,
            'unit_price' => $this->unit_price,
            'product_line' => $this->product_line,
            'user_id' => Auth::id(), // Set the user_id to the currently authenticated user's ID
        ]);

        $this->reset();
        $this->emit('refreshLivewireDatatable');
        $this->modalActionVisible = false;

        session()->flash('message', 'Commerce item added successfully.');
    }

    public function render()
    {
        return view('livewire.setting.general.commerce-item.add');
    }
}
