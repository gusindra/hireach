<?php

namespace App\Http\Livewire\Table;

use App\Models\Request;
use Carbon\Carbon;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;

class InBoundTable extends LivewireDatatable
{
    public $model = Request::class;
    public $hideable = 'select';
    public $filterMonth;

    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->filterMonth = Carbon::now()->format('Y-m');
    }

    public function builder()
    {
        $query = Request::query()
            ->where('requests.user_id', auth()->user()->currentTeam->user_id)
            ->where('requests.is_inbound', 1)
            ->with('agent', 'client')
            ->orderBy('requests.created_at', 'desc');

        $year = substr($this->filterMonth, 0, 4);
        $month = substr($this->filterMonth, 5, 2);

        $query->whereYear('requests.created_at', $year)
            ->whereMonth('requests.created_at', $month);

        return $query;
    }

    public function columns()
    {
        return [

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
            Column::name('created_at')->label('Creation Date'),
        ];
    }
}
