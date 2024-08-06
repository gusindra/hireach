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
    public $userId;

    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->filterMonth = Carbon::now()->format('Y-m');
    }

    public function builder()
    {
        $year = substr($this->filterMonth, 0, 4);
        $month = substr($this->filterMonth, 5, 2);
        
        $query = Request::query();
        if (auth()->user()->super && auth()->user()->super->first() && auth()->user()->super->first()->role == 'superadmin') {
            $query->where('requests.user_id', $this->userId);
        } else {
            $query->where('requests.user_id', auth()->user()->currentTeam->user_id);
            $query->whereYear('requests.created_at', $year)
                ->whereMonth('requests.created_at', $month);
        }
        $query->where('requests.is_inbound', 1)
            ->with('agent', 'client')
            ->orderBy('requests.created_at', 'desc');
        
        return $query;
    }
    
    /**
     * clientTbl
     *
     * @return array
     */
    private function clientTbl()
    {
        return [
            Column::callback(['from'], function ($from) {
                if ($from == 'bot') {
                    return 'BOT';
                }
                if ($from == 'api') {
                    return 'API';
                }
                return $from;
            })->label('Agent'),
            Column::name('client_id')->label('Client'),
            Column::name('reply')->label('Message'),
            Column::callback(['type'], function ($y) {
                return view('label.type', ['type' => $y]);
            })->label('Type'),
            Column::name('created_at')->label('Creation Date'),
        ];
    }
    
    /**
     * adminTbl
     *
     * @return array
     */
    private function adminTbl()
    {
        return [
            Column::callback(['from'], function ($from) {
                if ($from == 'bot') {
                    return 'BOT';
                }
                if ($from == 'api') {
                    return 'API';
                }
                return $from;
            })->label('Agent'),
            Column::name('client_id')->label('Client'),
            Column::name('reply')->label('Message'),
            Column::callback(['type'], function ($y) {
                return view('label.type', ['type' => $y]);
            })->label('Type'),
            Column::name('created_at')->label('Creation Date'),
        ];
    }

    public function columns()
    {
        if ((auth()->user()->super && auth()->user()->super->first() && auth()->user()->super->first()->role == 'superadmin') || (auth()->user()->activeRole && str_contains(auth()->user()->activeRole->role->name, "Admin"))) {
            return $this->adminTbl();
        }
        return $this->clientTbl();
    }
}
