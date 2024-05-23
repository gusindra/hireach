<?php

namespace App\Http\Livewire\Order;

use App\Models\Order;
use Livewire\Component;

class OrderProgress extends Component
{

    public $orderId;
    public $status;
    public  function mount($id)
    {
        $this->orderId = $id;
        $this->status = Order::where('id', $this->orderId)->first();
    }
    public function update()
    {
        Order::find($this->orderId)
            ->update(['status' => 'unpaid']);
    }
    public function render()
    {
        return view('livewire.order.order-progress');
    }
}
