<?php

namespace App\Http\Livewire\Table;

use App\Models\Campaign;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;

class CampaignUserTable extends LivewireDatatable
{
    public $user;

    public function builder()
    {
        return Campaign::query()->where('user_id', $this->user->id);
    }

    public function columns()
    {
        return [

            Column::name('channel')
                ->label('Channel')
                ->searchable(),

            Column::name('provider')
                ->label('Provider')
                ->searchable(),

            Column::name('title')
                ->label('Title')
                ->searchable(),

            Column::name('from')
                ->label('From'),

            Column::name('to')
                ->label('To'),

            Column::name('text')
                ->label('Text'),



            Column::name('request_type')
                ->label('Request Type'),

            Column::name('status')
                ->label('Status'),

            NumberColumn::name('budget')
                ->label('Budget'),

            DateColumn::name('created_at')
                ->label('Created At')
                ->format('d M Y'),
        ];
    }
}
