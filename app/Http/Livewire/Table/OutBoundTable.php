<?php

namespace App\Http\Livewire\Table;

use App\Models\Request;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;

class OutBoundTable extends LivewireDatatable
{
    public $model = Request::class;
    public $hideable = 'select';

    public function builder()
    {
        return Request::query()
            ->where('requests.user_id', auth()->user()->currentTeam->user_id)
            ->where('requests.is_inbound', 0)
            ->with('agent', 'client')
            ->orderBy('created_at', 'desc');
    }

    public function columns()
    {
        return [
            Column::name('user_id')->label('User')->filterable(),
            Column::name('created_at')->label('Creation Date')->filterable(),
            NumberColumn::name('id')->label('ID')->sortBy('id'),
            Column::callback(['agent.name', 'from'], function ($agent, $from) {
                if ($from == 'bot') {
                    return 'BOT';
                }
                if ($from == 'api') {
                    return 'API';
                }
                return $agent;
            })->label('Agent'),
            Column::name('client.name')->label('Client'),
            Column::name('reply')->label('Message'),
            Column::callback(['type'], function ($y) {
                return view('label.type', ['type' => $y]);
            })->label('Type'),
        ];
    }
}
