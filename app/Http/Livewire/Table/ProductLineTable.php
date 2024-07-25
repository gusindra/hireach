<?php

namespace App\Http\Livewire\Table;

use App\Models\ProductLine;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;

class ProductLineTable extends LivewireDatatable
{
    public function builder()
    {
        return ProductLine::query();
    }

    function columns()
    {
        return [
            Column::callback(['name','id'], function ($name, $id) {
                return view('datatables::link', [
                    'href' => "/admin/setting/product-line/" . $id,
                    'slot' => strtoupper($name)
                ]);
            })->label('Name')->searchable(),
            Column::name('type')->label('type')->searchable(),
            Column::name('company.name')->label('company')->searchable(),

            NumberColumn::name('id')->label('Action')->sortBy('id')->callback('id', function ($value) {
                // return view('datatables::link', [
                //     'href' => "/admin/setting/product-line/" . $value,
                //     'slot' => 'View'
                // ]);
            }),

        ];
    }
}
