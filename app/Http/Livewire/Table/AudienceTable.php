<?php

namespace App\Http\Livewire\Table;

use Livewire\Component;
use App\Models\Audience;
use App\Models\AudienceClient;
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


        return Audience::query()->with('audienceClients')->where('user_id', auth()->user()->currentTeam->user_id);
    }

    function columns()
    {
        return [
            Column::name('name')->callback('id', function ($value) {
                $audience = Audience::findOrFail($value);
                return view('datatables::link', [
                    'href' => "/audience/" . $value,
                    'slot' => $audience->name
                ]);
            })->label('Name')->searchable(),

            Column::name('description')->label('Descriptions')->searchable(),

            NumberColumn::name('user_id')->callback('audienceClients.audience_id', function ($value) {
                return $value;
            })->label('Total Audience Client'),

            DateColumn::name('created_at')->label('Inputed Date')->format('d F Y'),


        ];
    }
}
