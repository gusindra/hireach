<?php

namespace App\Http\Livewire\Table;

use App\Models\LogChange;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;

class LogChangeTable extends LivewireDatatable
{
    public function builder()
    {
        return LogChange::query()->with('user')->orderBy('created_at', 'desc');
    }

    public function columns()
    {
        return [
            Column::callback(['model', 'model_id'], function ($model, $id) {
                $array = ['Order', 'User', 'Quotation', 'Roles'];
                if (in_array($model, $array)){
                    return view('datatables::link', [
                        'href' => "/admin/" .strtolower($model).'/'. $id,
                        'slot' => $model
                    ]);
                }
                return $model;
            })->label('Model')->searchable()->filterable(),
            Column::name('model_id')->label('Model ID')->filterable(),
            Column::name('before')->label('Before')->filterable(),
            Column::callback(['user_id'], function ($id) {
                return view('datatables::link', [
                    'href' => "/admin/user/" . $id,
                    'slot' => $id
                ]);
            })->label('User ID')->searchable()->filterable(),
            Column::name('remark')->label('Remark')->filterable(),
            Column::name('created_at')->filterable()->label('Action Date')->sortBy('created_at'),
        ];
    }
}
