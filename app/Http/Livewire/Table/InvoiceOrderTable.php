<?php

namespace App\Http\Livewire\Table;

use App\Models\Billing;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;

class InvoiceOrderTable extends LivewireDatatable
{
    public $model = Billing::class;

    public function builder()
    {
        $query = Billing::where('status', 'paid')->orderBy('created_at', 'desc');

        return $query;
    }


    public function columns()
    {
        return [
            Column::callback(['code','id'], function ($name, $id) {
                return view('datatables::link', [
                    'href' => "/admin/invoice-order/" . $id,
                    'slot' => strtoupper($name)
                ]);
            })->label('Transaction ID')->searchable()->filterable(),
            Column::name('description')->label('Description')->filterable(),
            DateColumn::name('created_at')->label('Creation Date')->filterable(),
            NumberColumn::name('amount')->callback('amount', function ($value) {
                if ($value) {
                    return $value;
                }
                return 0;
            })->label('Amount')->filterable()->enableSummary(),
            Column::callback(['status'], function ($y) {
                return view('label.label', ['type' => $y]);
            })->label('Status')->filterable(['PAID', 'UNPAID']),
        ];
    }
}
