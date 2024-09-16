<?php

namespace App\Http\Livewire\Table;

use App\Models\Department;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;

class DepartmentUserTable extends LivewireDatatable
{
    public $model = Department::class;

    public function builder()
    {
        return Department::query()->with('client');
    }

    public function columns()
    {
        return [
            Column::name('source_id')->filterable()->label('ID'),
            Column::callback(['id','name','user_id'], function ($id,$name,$user) {
                return view('datatables::link', [
                    'href' => url('admin/user/' . $user . '/dept/' . $id),
                    'slot' => $name,
                    'class' => 'uppercase'
                ]);
                //return $x;
            })->label('Department')->searchable(),
            Column::callback(['client.id','client.name','user_id'], function ($id,$name,$user) {
                return view('datatables::link', [
                    'href' => url('admin/user/' . $user . '/client/' . $id),
                    'slot' => $name,
                    'class' => 'uppercase'
                ]);
                //return $x;
            })->label('Client'),
            Column::name('server')->filterable()->label('Server'),
            Column::name('ancestors')->filterable()->label('Ancestors')
        ];
    }
}
