<?php

namespace App\Http\Livewire\Table;

use App\Models\Provider;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;


class ProviderTable extends LivewireDatatable
{
    public $model = Provider::class;

    public function builder()
    {
        return Provider::query();
    }

    public function columns()
    {
        return [
            Column::callback(['name','id'], function ($name, $id) {
                return view('datatables::link', [
                    'href' => "/admin/settings/providers/" . $id,
                    'slot' => strtoupper($name)
                ]);
            })->label('Name')->searchable(),
            Column::name('code')->label('code'),
            Column::name('channel')->label('channel'),
            Column::name('company')->label('Company'),
            NumberColumn::name('id')->label('Action')->sortBy('id')->callback('id', function ($value) {
                // return view('datatables::link', [
                //     'href' => url('/admin/settings/providers/') . '/' . $value,
                //     'slot' => 'View'
                // ]);
            }),
        ];
    }
}
