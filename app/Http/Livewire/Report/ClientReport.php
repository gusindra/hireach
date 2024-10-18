<?php

namespace App\Http\Livewire\Report;

use Livewire\Component;

class ClientReport extends Component
{
    public $filterData = [
        'startDate' => null,
        'endDate' => null,
    ];

    public function mount()
    {
        // Initialize filterData if needed
        $this->filterData['startDate'] = null;
        $this->filterData['endDate'] = null;
    }

    // Apply filter based on selected dates
    public function applyFilter()
    {
        // Trigger refresh with new date filter inputs
        $this->emit('filterApplied', $this->filterData['startDate'], $this->filterData['endDate']);
    }

    // Clear the date filters and reset
    public function clearFilters()
    {
        $this->filterData['startDate'] = null;
        $this->filterData['endDate'] = null;

        $this->applyFilter(); // Apply filter with no date filters
    }

    public function render()
    {
        return view('livewire.report.client-report');
    }
}
