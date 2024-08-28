<?php

namespace App\Http\Livewire\Table;

use App\Models\Department;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;

class DepartmentTable extends LivewireDatatable
{
    public $model = Department::class;

    public function builder()
    {
        return Department::query();
    }

    public function columns()
    {
        return [
            Column::name('source_id')->filterable()->label('ID'),
            Column::name('name')->filterable()->label('Name'),
            Column::name('ancestors')->filterable()->label('Ancestors'),
            Column::name('parent')->filterable()->label('Parent'),
            Column::name('client_id')->filterable()->label('Client_id')->editable(),
            DateColumn::name('updated_at')->filterable()->label('Updated')
        ];
    }
}
