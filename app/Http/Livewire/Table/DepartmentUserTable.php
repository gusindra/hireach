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
    public $userId;
    public $departmentId = 0;

    public function builder()
    {
        $data = Department::query()
        ->leftJoin('clients', 'clients.id', '=', 'departments.client_id')
        ->where('departments.user_id', $this->userId);
        if($this->departmentId!=0){
            $source = Department::find($this->departmentId);
            $data = $data->where('parent', $source->source_id);
            if($data->count()==0 && $this->departmentId!=0){
                return Department::query()
                    ->leftJoin('clients', 'clients.id', '=', 'departments.client_id')
                    ->where('departments.id', $this->departmentId);
            }
        }
        return $data;
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
            Column::callback(['clients.id','clients.name','user_id'], function ($id,$name,$user) {
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
