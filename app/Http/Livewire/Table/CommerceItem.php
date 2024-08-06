<?php

namespace App\Http\Livewire\Table;

use App\Models\CommerceItem as ModelsCommerceItem;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class CommerceItem extends LivewireDatatable
{
    public $model = ModelsCommerceItem::class;

    public function columns()
    {
        return [
            Column::callback(['name','id'], function ($name, $id) {
                return view('datatables::link', [
                    'href' => "/admin/setting/commerce-item/" . $id,
                    'slot' => strtoupper($name)
                ]);
            })->label('Name')->searchable(),
            Column::callback(['type'], function ($y) {
                return view('label.type', ['type' => $y]);
            })->label('Type')->filterable(["SKU", "NOSKU", "ONE_TIME", "MONTHLY", "YEARLY"]),
            Column::name('sku')->label('SKU')->editable(),
            // Column::name('description')->truncate(150)->label('Description'),
            Column::name('unit_price')->label('Unit Price')->editable(),
            Column::name('general_discount')->label('Discount')->editable(),
            Column::name('productLine.name')->label('Produc Line'),

            // Column::callback(['id', 'name', 'source'], function ($id, $name, $s) {
                //     return view('tables.product-actions', ['id' => $id, 'name' => $name, 'url' =>  "/commercial/item/" . $id, 'source' => $s]);
                // })->label('Action'),
                BooleanColumn::name('status')->label('Active')->filterable(["active", "not active"]),
            NumberColumn::name('id')->label('Action')->sortBy('id')->callback('id', function ($value) {
                // return view('datatables::link', [
                //     'href' => "/admin/setting/commerce-item/" . $value,
                //     'slot' => 'View'
                // ]);
            }),

        ];
    }
}
