<?php

namespace App\Http\Livewire\Commercial\Item;

use App\Models\Stock;
use App\Models\Warehouse;
use Livewire\Component;

class UpdateStock extends Component
{
    public $stock;
    public $avaiable;
    public $price;
    public $sku;
    public $type;
    public $product;
    public $productId;
    public $warehouse;
    public $warehouseId;
    public $length;
    public $height;
    public $width;
    public $weight;

    public function mount($code)
    {
        $this->stock = Stock::find($code);
        $this->avaiable = $this->stock->stock;
        $this->price = $this->stock->price;
        $this->sku = $this->stock->sku;
        $this->type = $this->stock->type;
        $this->product = $this->stock->product;
        $this->productId = $this->stock->product_id;
        $this->warehouse = $this->stock->warehouse;
        $this->warehouseId = $this->stock->warehouse_id;
        $this->length = $this->stock->length;
        $this->height = $this->stock->height;
        $this->width = $this->stock->width;
        $this->weight = $this->stock->weight;
    }

    public function rules()
    {
        return [
            'stock' => 'required',
            'length' => 'required',
            'height' => 'required',
            'width' => 'required',
            'weight' => 'required',
        ];
    }

    public function modelData()
    {
        return [
            'sku'           => $this->sku,
            'stock'         => $this->avaiable,
            'price'         => $this->price,
            'warehouse_id'  => $this->warehouseId,
            'length'        => $this->length,
            'height'        => $this->height,
            'width'         => $this->width,
            'weight'        => $this->weight,
            'type'          => $this->avaiable > 0 ? 'avaiable' : 'outstock'
        ];
    }

    public function updateStock($id)
    {
        $this->validate();
        $old = Stock::find($id);
        Stock::find($id)->update($this->modelData());
        addLog(Stock::find($id), $old);
        $this->emit('saved');
    }

    public function deleteStock($id)
    {
        Stock::find($id)->delete();
        $this->emit('deleted');
    }

    public function readWarehouse()
    {
        return Warehouse::get();
    }

    public function render()
    {
        return view('livewire.commercial.item.update-stock', [
            'warehouses' => $this->readWarehouse()
        ]);
    }
}
