<?php

namespace App\Http\Livewire\Table;

use App\Models\Client;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use App\Models\User;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;
use Illuminate\Support\Facades\DB;

class ClientToUser extends LivewireDatatable
{
    public $model = Client::class;



    public function builder()
    {
        return Client::query()
            ->leftJoin('users', 'clients.email', '=', 'users.email')
            ->whereNull('users.email');
    }

    public function columns()
    {
        return [
            Column::name('name')->label('Name'),
            Column::name('phone')->label('Phone'),
            Column::name('email')->label('Email'),
            NumberColumn::name('id')->label('Detail')->sortBy('id')->callback('id', function ($value) {
                return view('datatables::link', [
                    'href' => 'client/' . $value,
                    'slot' => 'Convert to User'
                ]);
            }),
        ];
    }
}
