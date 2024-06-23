<?php

namespace App\Observers;

use App\Models\Billing;
use App\Models\OrderProduct;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class OrderProductObserver
{
    /**
     * Handle the Project "created" event.
     *
     * @param  \App\Models\Request  $request
     * @return void
     */
    public function created(OrderProduct $request)
    {
        $order = Order::find($request->model_id);
        $billing = Billing::where('order_id', $order->id);
        if ($order) {
            $subTotal = $request->latest()->first();

            $order->update([
                'total' => $subTotal->price,
                'vat' => 11
            ]);

            $billing->update([
                'amount' => $subTotal->price,
            ]);

            // Log::info($request->price.$request->qty.$request->total_percentage);
        }
    }

    /**
     * Handle the Project "deleted" event.
     *
     * @param  OrderProduct  $request
     * @return void
     */
    public function deleted(OrderProduct $request)
    {
        $order = Order::find($request->model_id);
        if ($order) {
            // $amount = $request->price * $request->qty * $request->total_percentage / 100;
            if (count($order->items) == 0) {
                $order->update([
                    'total' => 0
                ]);
            } else {
                $total = 0;
                foreach ($order->items as $item) {
                    $total = $total + ($item->price * $item->qty * $item->total_percentage / 100);
                }
                $order->update([
                    'total' => $total
                ]);
            }
        }
    }
}
