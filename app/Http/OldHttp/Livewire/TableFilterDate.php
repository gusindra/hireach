<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;

class TableFilterDate extends Component
{
    public $selectedDate;

    public function findOrder(){
        // dd(date($this->selectedDate));
        // dd($this->selectedDate);
        // dd(date('Y-m-d'));
        $order = Order::whereDate('date', '=', $this->selectedDate)->orderBy('created_at', 'desc')->get();
        // dd($order);
        return $order;
    }

    public function render()
    {
        return view('livewire.table-filter-date', [
            'data' => $this->findOrder()
        ]);
    }
}
