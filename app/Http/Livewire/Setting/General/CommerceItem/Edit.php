<?php

namespace App\Http\Livewire\Setting\General\CommerceItem;

use App\Models\CommerceItem;
use App\Models\ProductLine;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Edit extends Component
{
    use AuthorizesRequests;
    public $commerceItem;
    public $productLines;
    public $modalActionVisible = false;
    public $input = [
        'sku' => '',
        'name' => '',
        'spec' => '',
        'source_id' => '',
        'type' => '',
        'unit' => 1,
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
        'input.type' => 'required|string|max:255',
        'input.unit' => 'required|max:50',
        'input.status' => 'required',
        'input.unit_price' => 'required|numeric',
        'input.spec' => 'nullable|string|max:255',
        'input.description' => 'nullable|string',
        'input.general_discount' => 'nullable|numeric',
        'input.fs_price' => 'nullable|numeric',
        'input.way_import' => 'nullable|string|max:255',
        // 'input.product_line' => 'integer|exists:product_lines,id',
    ];

    /**
     * modalAction
     *
     * @return void
     */
    public function modalAction()
    {
        $this->modalActionVisible = true;
    }

    /**
     * mount
     *
     * @param  mixed $commerceItem
     * @return void
     */
    public function mount($commerceItem)
    {
        $this->commerceItem = CommerceItem::findOrFail($commerceItem->id);
        $this->input['sku'] = $this->commerceItem->sku ?? '';
        $this->input['name'] = $this->commerceItem->name ?? '';
        $this->input['spec'] = $this->commerceItem->spec ?? '';
        $this->input['source_id'] = $this->commerceItem->source_id ?? '';
        $this->input['type'] = $this->commerceItem->type ?? '';
        $this->input['unit'] = $this->commerceItem->unit ?? 1;
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

    /**
     * modelData
     *
     * @return array
     */
    public function modelData()
    {
        if ($this->input['type'] != 'nosku') {
            $this->input['unit'] = 1;
        }
        if ($this->input['type'] != 'sku' || $this->input['type'] != 'nosku') {
            $this->input['way_import'] = 'none';
        }
        return $this->input;
    }

    /**
     * update
     *
     * @param  mixed $id
     * @return void
     */
    public function update($id)
    {
        $this->authorize('UPDATE_SETTING', 'SETTING');
        $this->validate();
        CommerceItem::findOrFail($id)->update($this->modelData());

        $this->emit('saved');
    }

    /**
     * delete
     *
     * @return Illuminate\Routing\Redirector::route
     */
    public function delete()
    {
        $this->authorize('DELETE_SETTING', 'SETTING');
        $this->commerceItem->delete();
        $this->modalActionVisible = false;
        return redirect()->route('settings.company');
    }

    public function render()
    {
        return view('livewire.setting.general.commerce-item.edit');
    }
}
