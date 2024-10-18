<?php

namespace App\Http\Livewire\Report;

use Livewire\Component;

class OrderReport extends Component
{
    public $startDate;
    public $endDate;

    public function mount()
    {
        $this->startDate = null;
        $this->endDate = null;
    }

    public function applyFilter()
    {
        // Emit event to update the table
        $this->emit('filterApplied', $this->startDate, $this->endDate);
    }

    public function clearFilter()
    {
        // Clear filter values
        $this->startDate = null;
        $this->endDate = null;

        // Emit event to reset the table
        $this->emit('filterApplied', null, null);
    }

    public function render()
    {
        return view('livewire.report.order-report');
    }
}
