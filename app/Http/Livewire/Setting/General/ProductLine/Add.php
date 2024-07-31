<?php

namespace App\Http\Livewire\Setting\General\ProductLine;

use App\Models\Company;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use App\Models\ProductLine; // Import the ProductLine model

class Add extends Component
{
    use AuthorizesRequests;
    public $name;
    public $company_id;
    public $company = [];

    public $modalActionVisible = false;

    protected $rules = [
        'name' => 'required',
        'company_id' => 'required',
    ];

    public function actionShowModal()
    {
        $this->modalActionVisible = true;
    }

    public function create()
    {
        $this->authorize('CREATE_SETTING', 'SETTING');
        $this->validate();

        $new = ProductLine::create([
            'name' => $this->name,
            'company_id' => $this->company_id,
        ]);
        addLog($new);
        $this->reset();
        $this->emit('refreshLivewireDatatable');
        $this->modalActionVisible = false;

        session()->flash('message', 'Product line added successfully.');
    }


    public function read()
    {
        $this->company = Company::all();
    }
    public function render()
    {
        return view('livewire.setting.general.product-line.add', ['company' => $this->read()]);
    }
}
