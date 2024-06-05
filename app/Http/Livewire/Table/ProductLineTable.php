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

            Column::name('name')->label('name')->searchable(),
            Column::name('type')->label('type')->searchable(),
            Column::name('company.name')->label('company')->searchable(),

            NumberColumn::name('id')->label('Detail')->sortBy('id')->callback('id', function ($value) {
                return view('datatables::link', [
                    'href' => "/admin/setting/product-line/" . $value,
                    'slot' => 'View'
                ]);
            }),

        ];
    }
}
