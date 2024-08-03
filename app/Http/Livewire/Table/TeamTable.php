<?php

namespace App\Http\Livewire\Table;

use App\Models\Team;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;

class TeamTable extends LivewireDatatable
{
    public $model = Team::class;

    public function builder()
    {
        return Team::query()->where('user_id', '=', auth()->user()->id);
    }

    public function columns()
    {
        return [
            Column::callback(['name','id'], function ($name,$id) {
                return view('datatables::link', [
                    'href' => "/teams/" . $id,
                    'slot' => $name
                ]);
            })->label('Name')->searchable(),
    		DateColumn::name('created_at')->label('Created Date'),
    	];
    }
}
