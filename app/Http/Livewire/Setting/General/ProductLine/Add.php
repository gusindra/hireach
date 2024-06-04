<?php

namespace App\Http\Livewire\Setting\General\ProductLine;

use App\Models\Company;
use Livewire\Component;
use App\Models\ProductLine; // Import the ProductLine model

class Add extends Component
{
    public $name;
    public $company_id;
    public $company = [];

    public $modalActionVisible = false;

    protected $rules = [
        'name' => 'required',
        'company_id' => 'required',
    ];

    public function mount()
    {
        $this->company = Company::all();
    }
    public function actionShowModal()
    {
        $this->modalActionVisible = true;
    }

    public function create()
    {
        $this->validate();

        ProductLine::create([
            'name' => $this->name,
            'company_id' => $this->company_id,
        ]);

        $this->reset();
        $this->emit('refreshLivewireDatatable');
        $this->modalActionVisible = false;

        session()->flash('message', 'Product line added successfully.');
    }

    public function render()
    {
        return view('livewire.setting.general.product-line.add');
    }
}
