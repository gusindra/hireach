<?php

namespace App\Http\Livewire\Table;

use Livewire\Component;
use App\Models\Client;
use Illuminate\Support\Str;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class ClientDatatables extends LivewireDatatable
{
    public $model = Client::class;
    public $export_name = 'DATA_CLIENT';
    public $hideable = 'select';

    public function builder()
    {
        return Client::query()->where('user_id', auth()->user()->currentTeam->user_id);

    }

    function columns()
    {
    	return [
            Column::callback(['id'], function ($x) {
                return view('datatables::link', [
                    'href' => "/user/" . $x,
                    'slot' => $x
                ]);
                //return $x;
            })->label('ID')->searchable(),
    		Column::callback(['uuid'], function ($x) {
                return view('datatables::link', [
                    'href' => "/contact/" . $x,
                    'slot' => substr($x, 30)
                ]);
            })->label('UUID')->searchable(),
    		Column::name('name')->label('Name')->searchable(),
    		Column::name('phone')->label('Phone Number')->searchable(),
    		Column::name('email')->label('Email')->searchable(),
    		DateColumn::name('created_at')->label('Inputed Date')->searchable()->format('d F Y')
    	];
    }
}
