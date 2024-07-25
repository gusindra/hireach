<?php

namespace App\Http\Livewire\Table;

use App\Models\Permission as ModelsPermission;
use Illuminate\Support\Str;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;

class Permission extends LivewireDatatable
{
    public $model = ModelsPermission::class;
    public $modalDeleteVisible = false;



    public function builder()
    {
        return ModelsPermission::query();
    }

    public function deletePermission($id)
    {
        ModelsPermission::findOrFail($id)->delete();
    }

    public function columns()
    {
        return [
            Column::name('model')->searchable()->label('Menu'),
            Column::name('name')->searchable()->label('Permission'),
            Column::name('type')->label('Type'),
            // Column::callback('model', function ($value) {
            //     return view('datatables::link', [
            //         'href' => "/flow/" . Str::lower($value),
            //         'slot' => $value
            //     ]);
            // })->label('Model'),
            // NumberColumn::name('id')->label('Detail')->sortBy('id')->callback('id', function ($value) {
            //     return view('datatables::link', [
            //         'href' => "/roles/" . $value . '?month='.date('m').'&year='.date('Y'),
            //         'slot' => 'View'
            //     ]);
            // }),
            // Column::callback(['id'], function ($id) {
            //     return view('tables.delete-modal', ['id' => $id]);
            // })->label('Actions'),

        ];
    }
}
