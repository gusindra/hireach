<?php

namespace App\Observers;

use App\Models\Billing;
use App\Models\OrderProduct;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
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


        if ($request->model == 'Order') {

            $vatSetting = cache('vat_setting');

            if (empty($vatSetting)) {
                $vatSetting = cache()->remember('vat_setting', 1444, function () {
                    return Setting::where('key', 'vat')->latest()->first();
                });
            }

            $vatValue = $vatSetting ? $vatSetting->value : 0;

            $orderProducts = OrderProduct::where('model_id', $request->model_id)
                ->where('name', '!=', 'Tax')
                ->get();

            $totalPrice = $orderProducts->sum(function ($item) {
                return $item->price * $item->qty;
            });

            $taxPrice = $totalPrice * ($vatValue / 100);


            $new = OrderProduct::updateOrCreate(
                [
                    'model' => 'Order',
                    'model_id' => $request->model_id,
                    'name' => 'Tax'
                ],
                [
                    'qty' => 1,
                    'unit' => 1,
                    'price' => $taxPrice,
                    'note' => 'VAT/PPN @ ' . $vatValue . '%',
                    'user_id' => 0,
                ]
            );

            addLog($new);

            $order = Order::find($request->model_id);


            $tax = OrderProduct::where('model_id', $request->model_id)->where('name', 'Tax')->latest()->first();
            $billing = Billing::where('order_id', $order->id)->first();
            $vat = cache('vat_setting');

            if (empty($vat)) {
                $vat = cache()->remember('vat_setting', 1444, function () {
                    return Setting::where('key', 'vat')->latest()->first();
                });
            }
            if ($order) {
                $subTotal = OrderProduct::latest()->first();

                if ($order) {
                    if (count($order->items) == 0) {
                        $order->update([
                            'total' => 0,
                            'vat' => $vat->value
                        ]);
                    } else {
                        $total = 0;

                        foreach ($orderProducts as $item) {
                            $total += ($item->price * $item->qty * $item->total_percentage / 100);
                        }

                        $order->update([
                            'total' => $totalPrice + $taxPrice,
                            'vat' => $vat->value
                        ]);

                    }
                }
                if ($billing) {

                    $billing->update([
                        'amount' => $totalPrice + $taxPrice
                    ]);
                }
            }
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
        if ($request->model == 'Order') {
            $vatSetting = cache('vat_setting');

            if (empty($vatSetting)) {
                $vatSetting = cache()->remember('vat_setting', 1444, function () {
                    return Setting::where('key', 'vat')->latest()->first();
                });
            }
            $vatValue = $vatSetting ? $vatSetting->value : 0;


            $orderProducts = OrderProduct::where('model_id', $request->model_id)
                ->where('name', '!=', 'Tax')
                ->get();


            $totalPrice = $orderProducts->sum(function ($item) {
                return $item->price * $item->qty;
            });


            $taxPrice = $totalPrice * ($vatValue / 100);


            OrderProduct::updateOrCreate(
                [
                    'model' => 'Order',
                    'model_id' => $request->model_id,
                    'name' => 'Tax'
                ],
                [
                    'qty' => 1,
                    'unit' => 1,
                    'price' => $taxPrice,
                    'note' => 'VAT/PPN @ ' . $vatValue . '%',
                    'user_id' => 0,
                ]
            );


            $order = Order::find($request->model_id);
            $billing = Billing::where('order_id', $order->id)->first();

            if ($order) {
                $total = 0;

                foreach ($orderProducts as $item) {
                    $total += $item->price * $item->qty;
                }


                $order->update([
                    'total' => $totalPrice + $taxPrice,
                    'vat' => $vatValue
                ]);


                if ($billing) {
                    $billing->update([
                        'amount' => $totalPrice + $taxPrice
                    ]);
                }
            }
        }
    }

}
