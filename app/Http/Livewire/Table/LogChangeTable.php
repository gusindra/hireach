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
            Column::name('model')->label('Model'),
            Column::name('model_id')->label('Model ID'),
            Column::name('before')->label('Before'),
            Column::name('user.name')->label('User'),
            Column::name('remark')->label('Remark'),
            Column::name('created_at')->label('Action Date')->sortBy('created_at'),
        ];
    }
}
