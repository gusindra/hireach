<?php

namespace App\Http\Livewire\Commercial\Item;

use Livewire\Component;
use App\Models\CommerceItem;
use App\Models\Stock;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Auth;

class AddStock extends Component
{
    public $modalActionVisible = false;
    public $addStock;
    public $addSku;
    public $addPrice;
    public $addLength;
    public $addHeight;
    public $addWidth;
    public $addWeight;
    public $productId;
    public $product;
    public $warehouseId;
    public $warehouses = [];

    public function mount($productId)
    {
        $this->productId = $productId;
        $this->product = CommerceItem::find($productId);
    }

    public function rules()
    {
        return [
            'stock' => 'required',
            'warehouseId' => 'required',
        ];
    }

    public function create()
    {
        dd($this->modelData());
        $this->validate();
        Stock::create($this->modelData());
        $this->modalActionVisible = false;
        $this->resetForm();
        // $this->emit('refreshLivewireDatatable');
    }

    public function modelData()
    {
        return [
            'stock'         => $this->addStock,
            'price'         => $this->addPrice,
            'sku'         => $this->addSku,
            'product_id'    => $this->productId,
            'warehouse_id'  => $this->warehouseId,
            'length'        => $this->addLength,
            'height'        => $this->addHeight,
            'width'         => $this->addWidth,
            'weight'        => $this->addWeight,
            'type'          => $this->addStock > 0 ? 'avaiable' : 'outstock'
        ];
    }

    public function resetForm()
    {
        $this->addStock = null;
        $this->productId = null;
        $this->warehouseId = null;
        $this->addPrice = null;
        $this->addLength = null;
        $this->addHeight = null;
        $this->addWidth = null;
        $this->addWeight = null;
    }

    /**
     * createShowModal
     *
     * @return void
     */
    public function actionShowModal()
    {
        $listId = $this->product->stock->pluck('warehouse_id');
        // dd($listId);
        $this->warehouses = Warehouse::whereNotIn('id', $listId)->get();
        $this->modalActionVisible = true;
    }

    public function render()
    {
        return view('livewire.commercial.item.add-stock');
    }
}
