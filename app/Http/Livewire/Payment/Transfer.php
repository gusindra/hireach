<?php

namespace App\Http\Livewire\Payment;

use App\Models\OrderProduct;
use Livewire\Component;
use App\Jobs\ProcessEmail;
use App\Models\Notice;

class Transfer extends Component
{
    public $order;
    public $check = 1;
    public $modalDetail = false;
    public $modalUpload = false;

    public $subTotal = 0;
    public $taxPrice = 0;
    public $total = 0;

    public function mount($order)
    {
        $this->order = $order;
    }

    public function checkPayment()
    {
        if ($this->order->notifications('unread')->count() == 0) {
            $this->emit('saved');
            $this->check = 0;
            Notice::create([
                'type' => 'message',
                'model' => 'Order',
                'model_id' => $this->order->id,
                'notification' => 'Konfirmasi pembayaran no ' . $this->order->no . ' Total Rp' . number_format($this->order->total),
                'user_id' => 1,
                'status' => 'unread'
            ]);

            //ProcessEmail::dispatch($this->order, 'payment_order');
        } else {
            $this->emit('already');
        }
    }

    public function uploadImage()
    {
        dd('uploadImage');
    }

    public function actionShowModal($modal)
    {
        if ($modal == 'detail') {
            $this->modalDetail = true;
        } elseif ($modal == 'upload') {
            $this->modalUpload = true;
        }
    }

    public function read()
    {
        return $this->check;
    }

    public function calc()
    {
        $orderProducts = OrderProduct::where('model_id', $this->order->id)
            ->where('name', '!=', 'Tax')
            ->get();

        $this->subTotal = $orderProducts->sum(function ($item) {
            return $item->price * $item->qty;
        });

        $this->taxPrice = $this->subTotal * ($this->order->vat / 100);
        $this->total = $this->subTotal + $this->taxPrice;
    }

    public function render()
    {
        $this->calc();

        return view('livewire.payment.transfer', [
            'check_status' => $this->read(),
            'subTotal' => $this->subTotal,
            'tax' => $this->taxPrice,
            'total' => $this->total,
        ]);
    }
}
