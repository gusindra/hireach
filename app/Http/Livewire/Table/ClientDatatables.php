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
        // return Client::query()->with('teams')
        //     ->whereHas('teams', function ($query) {
        //         $query->where([
        //             'teams.id' => auth()->user()->currentTeam->id
        //         ]);
        //     })->where('user_id', auth()->user()->currentTeam->user_id);
    }

    function columns()
    {
    	return [
    		Column::callback(['uuid'], function ($x) {
                return $x;
            })->label('Type')->label('ID')->searchable(),
    		// Column::name('uuid')->label('ID')->sortBy('id')->searchable(),
    		Column::name('name')->label('Name')->searchable(),
    		Column::name('phone')->label('Phone Number')->searchable(),
    		DateColumn::name('created_at')->label('Inputed Date')->format('d F Y')
    	];
    }
}
