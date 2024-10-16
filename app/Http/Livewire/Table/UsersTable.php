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
    public $type = 'user';

    public function builder()
    {
        $user = User::query()->orderBy('created_at', 'desc');
        // $role = $this->type;
        if ($this->type == "admin") {
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
                    'href' => $this->type == "admin" ? "/admin/autor/" . $id : "/admin/user/" . $id,
                    'slot' => $name
                ]);
            })->label('Name ID')->filterable()->searchable(),
            Column::name('email')->filterable()->label('Email')->searchable(),
            Column::name('phone_no')->filterable()->label('Phone Number')->searchable(),
            Column::callback(['id'], function ($id) {
                return balance($id, 0, 'id');
            })->label('Balance')->searchable(),
            DateColumn::name('created_at')->label('Creation Date')->searchable()
        ];
    }
}
