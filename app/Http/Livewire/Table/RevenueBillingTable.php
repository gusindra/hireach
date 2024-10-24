<?php

namespace App\Http\Livewire\Table;

use App\Models\Billing;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Carbon\Carbon;

class RevenueBillingTable extends LivewireDatatable
{
    public $status = '';

    public function builder()
    {
        return Billing::when($this->status, function ($query) {
            return $query->where('status', $this->status);
        })
        ->whereBetween('created_at', [Carbon::now()->subMonth(), Carbon::now()]);
    }


    public function columns()
    {
        return [
            Column::name('code')->label('Billing Code'),
            Column::name('amount')->label('Amount'),
            Column::name('status')->label('Status'),
            DateColumn::name('created_at')->label('Created At')->filterable(),
        ];
    }
}
