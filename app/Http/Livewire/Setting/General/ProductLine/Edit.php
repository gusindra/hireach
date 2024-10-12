<?php

namespace App\Http\Livewire\Setting\General\ProductLine;

use App\Models\Company;
use App\Models\ProductLine;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Edit extends Component
{
    use AuthorizesRequests;
    public $productLine;
    public $company;
    public $modalActionVisible = false;


    public $input = [
        'name' => '',
        'type' => '',
        'company_id' => '',
    ];

    protected $rules = [
        'input.name' => 'required|string|max:255',
        'input.type' => 'required|string|max:255',
        'input.company_id' => 'required|integer|exists:companies,id',
    ];

    public function modalAction()
    {
        $this->modalActionVisible = true;
    }
    public function mount($productLine)
    {

        $this->productLine = ProductLine::find($productLine->id);
        $this->input['name'] = $this->productLine->name ?? '';
        $this->input['type'] = $this->productLine->type ?? '';
        $this->input['company_id'] = $this->productLine->company_id ?? '';
        $this->company = Company::all();
    }

    public function updateProductLine($id)
    {
        $this->authorize('UPDATE_SETTING', 'SETTING');
        $this->validate();
        $productLine = ProductLine::findOrFail($id);
        $productLine->update($this->input);

        $this->emit('saved');
    }
    public function delete()
    { 
        $this->authorize('DELETE_SETTING', 'SETTING');
        $this->productLine->delete();
        $this->modalActionVisible = false;
        return redirect()->to('admin/settings/company');
        // return redirect()->route('settings.company');
    }
    public function render()
    {
        return view('livewire.setting.general.product-line.edit');
    }
}
