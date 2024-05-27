<?php

namespace App\Http\Livewire\Order;

use App\Models\Order;
use Livewire\Component;

class OrderProgress extends Component
{

    public $orderId;
    public $status;
    public $order;
    public $errorMessage;

    public  function mount($id)
    {
        $this->orderId = $id;
        $this->status = Order::where('id', $this->orderId)->first();
        $this->order = Order::find($id);
    }
    public function update()
    {
        $item = $this->order->items->count();
        $commission = $this->order->items->count();

        $this->errorMessage = '';
        $fields = [
            'name',
            'status',
            'no',
            'date',
            'customer_id',
        ];
        foreach ($fields as $field) {

            if (empty($this->order->$field) || $item == 0 || $commission == 0) {
                $this->errorMessage = 'Please  fill in all fields !';
            }
        }

        if ($this->errorMessage) {
            return;
        }

        Order::find($this->orderId)
            ->update(['status' => 'unpaid']);
    }
    public function render()
    {
        return view('livewire.order.order-progress');
    }
}
