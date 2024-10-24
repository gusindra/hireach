<?php

namespace App\Http\Livewire\Table;

use App\Models\Order;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Carbon\Carbon;
use Mediconesystems\LivewireDatatables\NumberColumn;

class RevenueOrderTable extends LivewireDatatable
{
    public $status;

    public function builder()
    {
        return Order::when($this->status, function ($query) {
            return $query->where('status', $this->status);
        })
        ->whereBetween('date', [Carbon::now()->subMonth(), Carbon::now()]);
    }

    public function columns()
    {
        return [
            Column::name('name')->label('Order Name'),
            Column::name('no')->label('Order Number'),
            Column::name('type')->label('Order Type'),
            Column::name('entity_party')->label('Entity Party'),
            Column::name('total')->label('Total'),
            Column::name('status')->label('Status'),
            DateColumn::name('date')->label('Date')->filterable(),
            NumberColumn::name('total:sum')->label('Sum Sum'),
        ];
    }
}