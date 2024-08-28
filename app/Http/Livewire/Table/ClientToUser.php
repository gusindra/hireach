<?php

namespace App\Http\Livewire\Table;

use App\Models\Client;
use App\Models\User; // Import model User
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;

class ClientToUser extends LivewireDatatable
{
    public $model = Client::class;
    public $user;

    public $params = ['user'];

    public function builder()
    {
        $query = Client::query();

        if (!empty($this->user)) {
            $query->where('user_id', $this->user->id);
        }

        return $query;
    }

    public function columns()
    {
        return [
            Column::callback(['id','name'], function ($id,$name) {
                return view('datatables::link', [
                    'href' => url('admin/user/' . $this->user->id . '/client/' . $id),
                    'slot' => $name,
                    'class' => 'uppercase'
                ]);
                //return $x;
            })->label('ID')->searchable(),
            Column::name('phone')->label('Phone'),
            Column::name('email')->label('Email'),

        ];
    }
}
