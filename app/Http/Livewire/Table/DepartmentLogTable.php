<?php

namespace App\Http\Livewire\Table;

use App\Models\LogChange;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class DepartmentLogTable extends LivewireDatatable
{
    public $deptId;
    public function builder()
    {
        return LogChange::where('model', 'Department')->where('model_id',$this->deptId);
    }

    public function columns()
    {

        return[
            Column::name('before')->label('LOG'),
            Column::name('created_at')->label('Created'),
        ];

    }
}
