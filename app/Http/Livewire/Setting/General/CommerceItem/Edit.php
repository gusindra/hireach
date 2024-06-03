<?php

namespace App\Http\Livewire\Setting\General\CommerceItem;

use App\Models\CommerceItem;
use App\Models\ProductLine;
use Livewire\Component;

class Edit extends Component
{
    public $commerceItem;
    public $productLines;
    public $modalActionVisible = false;
    public $input = [
        'sku' => '',
        'name' => '',
        'spec' => '',
        'source_id' => '',
        'type' => '',
        'unit' => '',
        'description' => '',
        'general_discount' => '',
        'fs_price' => '',
        'unit_price' => '',
        'way_import' => '',
        'status' => '',
        'product_line' => '',
        'user_id' => '',
    ];
    protected $rules = [
        'input.sku' => 'required|string|max:255',
        'input.name' => 'required|string|max:255',
        'input.spec' => 'nullable|string|max:255',
        'input.type' => 'required|string|max:255',
        'input.unit' => 'required|string|max:50',
        'input.description' => 'nullable|string',
        'input.general_discount' => 'nullable|numeric',
        'input.fs_price' => 'nullable|numeric',
        'input.unit_price' => 'required|numeric',
        'input.way_import' => 'nullable|string|max:255',
        'input.status' => 'required|string|max:50',
        'input.product_line' => 'required|integer|exists:product_lines,id',
    ];
    public function modalAction()
    {
        $this->modalActionVisible = true;
    }
    public function mount($commerceItem)
    {
        $this->commerceItem = CommerceItem::findOrFail($commerceItem->id);
        $this->input['sku'] = $this->commerceItem->sku ?? '';
        $this->input['name'] = $this->commerceItem->name ?? '';
        $this->input['spec'] = $this->commerceItem->spec ?? '';
        $this->input['source_id'] = $this->commerceItem->source_id ?? '';
        $this->input['type'] = $this->commerceItem->type ?? '';
        $this->input['unit'] = $this->commerceItem->unit ?? '';
        $this->input['description'] = $this->commerceItem->description ?? '';
        $this->input['general_discount'] = $this->commerceItem->general_discount ?? '';
        $this->input['fs_price'] = $this->commerceItem->fs_price ?? '';
        $this->input['unit_price'] = $this->commerceItem->unit_price ?? '';
        $this->input['way_import'] = $this->commerceItem->way_import ?? '';
        $this->input['status'] = $this->commerceItem->status ?? '';
        $this->input['product_line'] = $this->commerceItem->product_line ?? '';
        $this->input['user_id'] = $this->commerceItem->user_id ?? '';
        $this->productLines = ProductLine::all();
    }

    public function update($id)
    {
        $this->validate();
        $commerceItem = CommerceItem::findOrFail($id);
        $commerceItem->update($this->input);

        $this->emit('saved');
    }
    public function delete()
    {
        $this->commerceItem->delete();
        $this->modalActionVisible = false;
        return redirect()->route('settings.company');
    }
    public function render()
    {
        return view('livewire.setting.general.commerce-item.edit');
    }
}
