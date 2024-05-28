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
            Column::name('code')->label('code'),
            Column::name('name')->label('Name')->searchable(),
            NumberColumn::name('id')->label('Detail')->sortBy('id')->callback('id', function ($value) {
                return view('datatables::link', [
                    'href' => url('/admin/settings/providers/'). '/' . $value,
                    'slot' => 'View'
                ]);
            }),
        ];
    }
}
