<?php

namespace App\Http\Livewire\Table;

use App\Models\CommerceItem as ModelsCommerceItem;
use App\Models\ProductLine;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class CommerceItem extends LivewireDatatable
{
    public $model = ModelsCommerceItem::class;
    // public $complex = true;

    public function builder()
    {
        $data = ModelsCommerceItem::query()
        ->leftJoin('product_lines', 'product_lines.id', '=', 'commerce_items.product_line');

        return $data;
    }

    public function columns()
    {
        $productLine =  ProductLine::pluck('name');
        
        return [
            Column::callback(['name','id'], function ($name, $id) {
                return view('datatables::link', [
                    'href' => "/admin/setting/commerce-item/" . $id,
                    'slot' => strtoupper($name)
                ]);
            })->label('Name')->filterable()->searchable(),
            Column::callback(['type'], function ($y) {
                return view('label.type', ['type' => $y]);
            })->label('Type')->filterable(["SKU", "NOSKU", "ONE_TIME", "MONTHLY", "YEARLY"]),
            Column::name('sku')->filterable()->label('SKU')->editable(),
            Column::name('unit_price')->label('Unit Price')->editable(),
            Column::name('spec')->label('Spesification')->editable(),
            Column::name('general_discount')->label('Discount')->editable(),
            Column::name('productLine.name')->filterable($productLine)->label('Produc Line'),

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
