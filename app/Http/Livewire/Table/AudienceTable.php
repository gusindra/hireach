<?php

namespace App\Http\Livewire\Table;

use Livewire\Component;
use App\Models\Audience;
use Illuminate\Support\Str;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class AudienceTable extends LivewireDatatable
{
    public $model = Audience::class;
    public $export_name = 'DATA_CLIENT';
    public $hideable = 'select';

    public function builder()
    {
        return Audience::query()->where('user_id', auth()->user()->currentTeam->user_id);
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
    		Column::callback(['id'], function ($x) {
                // return view('datatables::link', [
                //     'href' => "/audience/" . $x
                // ]);
                return $x;
            })->label('ID')->searchable(),
    		Column::name('name')->label('Name')->searchable(),
    		DateColumn::name('created_at')->label('Inputed Date')->format('d F Y'),
            NumberColumn::name('id')->label('Detail')->sortBy('id')->callback('id', function ($value) {
                return view('datatables::link', [
                    'href' => "/audience/" . $value,
                    'slot' => 'View Audience'
                ]);
            }),
    	];
    }
}
