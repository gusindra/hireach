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
            Column::callback(['id'], function ($x) {
                return view('datatables::link', [
                    'href' => "/admin/user/" . $x,
                    'slot' => $x
                ]);
                //return $x;
            })->label('ID')->searchable(),
            Column::name('name')->label('Name'),
            Column::name('email')->label('Email'),
            Column::name('phone_no')->label('Phone Number'),
            DateColumn::name('created_at')->label('Creation Date')
        ];
    }
}
