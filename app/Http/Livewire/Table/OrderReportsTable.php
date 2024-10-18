<?php

namespace App\Http\Livewire\Table;

use App\Models\Order; // Sesuaikan dengan model Order Anda
use Carbon\Carbon;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;

class OrderReportsTable extends LivewireDatatable
{
    public $startDate; // Start date for filtering
    public $endDate;   // End date for filtering

    protected $listeners = ['filterApplied' => 'updateDateFilter'];

    public function builder()
    {
        $query = Order::query(); // Ganti dengan query yang sesuai untuk model Order

        // Apply date filtering if both start and end dates are provided
        if ($this->startDate && $this->endDate) {
            $query = $query->whereBetween('date', [
                Carbon::parse($this->startDate)->startOfDay(),
                Carbon::parse($this->endDate)->endOfDay()
            ]);
        }

        return $query;
    }

    public function updateDateFilter($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function columns()
    {
        return [
            Column::name('no')->label('No')->sortable(),
            Column::name('name')->label('Name')->searchable()->sortable(),
            Column::name('type')->label('Type')->sortable(),
            Column::name('entity_party')->label('Entity Party')->sortable(),
            Column::name('vat')->label('VAT')->sortable(),
            Column::name('total')->label('Total')->sortable(),
            Column::name('customer_id')->label('Customer ID')->sortable(),
            Column::name('user_id')->label('User ID')->sortable(),
            Column::name('status')->label('Status')->sortable(),
            Column::name('date')->label('Date')->sortable(),
        ];
    }
}
