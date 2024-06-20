<?php

namespace App\Http\Livewire\Table;

use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use App\Models\Campaign;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;

class CampaignTable extends LivewireDatatable
{
    public $model = Campaign::class;

    public function builder()
    {
        return Campaign::query()->where('user_id', auth()->user()->id);
    }

    public function columns()
    {
        return [
            Column::name('title')->label('Title'),
            NumberColumn::name('id')->label('Detail')->sortBy('id')->callback('id', function ($value) {
                return view('datatables::link', [
                    'href' => 'campaign/' . $value,
                    'slot' => 'View'
                ]);
            }),
        ];
    }
}
