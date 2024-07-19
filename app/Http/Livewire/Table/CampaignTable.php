<?php

namespace App\Http\Livewire\Table;

use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use App\Models\Campaign;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;

class CampaignTable extends LivewireDatatable
{
    public $model = Campaign::class;

    public function builder()
    {
        return Campaign::query()->orderBy('created_at', 'desc')->where('campaigns.user_id', '=', auth()->user()->id);
    }

    public function columns()
    {
        return [
            Column::callback(['status'], function ($y) {
                return view('label.type', ['type' => $y]);
            })->label('Status'),
            Column::callback(['title','uuid'], function ($title, $id) {
                return view('datatables::link', [
                    'href' => 'campaign/' . $id,
                    'slot' => $title
                ]);
            })->label('Title'),
            Column::callback(['audience_id', 'audience.name'], function ($id,$name) {
                return $name;
            })->label('Audience'),
            Column::name('way_type')->label('Resource'),
            Column::name('provider')->label('Provider'),
            DateColumn::name('created_at')->label('Creation Date'),
        ];
    }
}
