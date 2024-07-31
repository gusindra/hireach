<?php

namespace App\Http\Livewire\Order;

use App\Models\Order;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class OrderProgress extends Component
{
    use AuthorizesRequests;
    public $orderId;
    public $status;
    public $order;
    public $errorMessage;

    public function mount($id)
    {
        $this->orderId = $id;
        $this->status = Order::where('id', $this->orderId)->first();
        $this->order = Order::find($id);
    }
    public function update()
    {
        $this->authorize('UPDATE_ORDER', 'ORDER');
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
                $this->errorMessage = 'Please fill in all fields!';
            }
        }

        if ($this->errorMessage) {
            return;
        }

        $order = Order::find($this->orderId);
        $oldOrderData = $order->toArray();

        $order->update(['status' => 'unpaid']);
        $oldOrderJson = json_encode($oldOrderData);

        addLog(Order::find($this->orderId), $oldOrderJson);

        return redirect('admin/order/' . $this->orderId);
    }


    public function render()
    {
        return view('livewire.order.order-progress');
    }
}
