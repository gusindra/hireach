<?php

namespace App\Http\Livewire\Table;

use App\Models\CommerceItem as ModelsCommerceItem;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class CommerceItem extends LivewireDatatable
{
    public $model = ModelsCommerceItem::class;

    public function columns()
    {
        return [
            Column::callback(['type'], function ($y) {
                return view('label.type', ['type' => $y]);
            })->label('Type')->filterable(["SKU", "NOSKU", "ONE_TIME", "MONTHLY", "YEARLY"]),
            Column::callback(['name', 'sku'], function ($name, $sku) {
                return "<span class='font-bold'>" . $name . "</span><br><small class='text-sx'>sku: " . $sku . "</small>";
            })->label('Name')->searchable()->filterable(),
            Column::name('description')->truncate(150)->label('Description'),
            Column::callback(['status'], function ($y) {
                return view('label.type', ['type' => $y]);
            })->label('Status')->filterable(["active", "not active"]),
            Column::callback(['id', 'name', 'source'], function ($id, $name, $s) {
                return view('tables.product-actions', ['id' => $id, 'name' => $name, 'url' =>  "/commercial/item/" . $id, 'source' => $s]);
            })->label('Action'),
            NumberColumn::name('id')->label('Detail')->sortBy('id')->callback('id', function ($value) {
                return view('datatables::link', [
                    'href' => "/admin/setting/commerce-item/" . $value,
                    'slot' => 'View'
                ]);
            }),

        ];
    }
}
