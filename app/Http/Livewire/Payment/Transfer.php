<?php

namespace App\Http\Livewire\Payment;

use Livewire\Component;
use App\Jobs\ProcessEmail;
use App\Models\Notice;

class Transfer extends Component
{
    public $order;
    public $check = 1;
    public $modalDetail = false;
    public $modalUpload = false;

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

    public function render()
    {
        return view('livewire.payment.transfer', [
            'check_status' => $this->read()
        ]);
    }
}
