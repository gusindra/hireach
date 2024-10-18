<?php

namespace App\Http\Livewire\Table;

use App\Models\User;
use Carbon\Carbon;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;

class ClientReportsTable extends LivewireDatatable
{
    public $startDate;
    public $endDate;

    protected $listeners = ['filterApplied' => 'updateDateFilter'];

    public function builder()
    {
        $query = User::noadmin();


        if ($this->startDate && $this->endDate) {
            $query = $query->whereBetween('created_at', [
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
        $this->builder();
    }

    public function columns()
    {
        return [
            Column::name('id')->label('ID')->sortable(),
            Column::name('name')->label('Name')->searchable()->sortable(),
            Column::name('email')->label('Email')->searchable()->sortable(),
            Column::name('created_at')->label('Created At')->sortable(),
            Column::name('updated_at')->label('Updated At')->sortable(),
        ];
    }
}
