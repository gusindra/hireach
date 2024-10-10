<?php

namespace App\Http\Livewire\Table;

use App\Models\User;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;

class UsersTable extends LivewireDatatable
{
    public $model = User::class;

    public function builder()
    {
        $user = User::query();
        $role = request()->get('role');
        if ($role === 'admin') {
            $user->whereHas('super');
        } else {
            $user->whereDoesntHave('super');
        }

        return $user;
    }

    public function columns()
    {
        return [
            Column::callback(['name','id'], function ($name, $id) {
                return view('datatables::link', [
                    'href' => "/admin/user/" . $id,
                    'slot' => $name
                ]);
            })->label('Name ID')->filterable()->searchable(),
            Column::name('email')->filterable()->label('Email')->searchable(),
            Column::name('phone_no')->filterable()->label('Phone Number')->searchable(), 
            Column::callback(['id'], function ($name) {
                return balance($name, 0, 'id');
            })->label('Balance')->searchable(),
            DateColumn::name('created_at')->label('Creation Date')->searchable()
        ];
    }
}
