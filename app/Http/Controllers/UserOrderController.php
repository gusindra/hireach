<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\User;
use Illuminate\Http\Request;

class UserOrderController extends Controller
{
    public function orderUser()
    {
        $this->authorize('VIEW_ANY_CHAT_USR');
        return view('assistant.invoice.index');
    }

    public function showUserOrder(Order $order)
    {
        $client = Client::where('uuid', $order->customer_id)->first();
        $user = User::where('email', $client->email)->first();

        $this->authorize('VIEW_ORDER', $user->id);
        $orderProducts = OrderProduct::where('model_id', $order->id)
            ->where('name', '!=', 'Tax')
            ->get();

        $subTotal = $orderProducts->sum(function ($item) {
            return $item->price * $item->qty;
        });

        $taxPrice = $subTotal * ($order->vat / 100);


        return view('assistant.order.show-order-user', [
            'data' => $order,
            'orderProducts' => $orderProducts,
            'subTotal' => $subTotal,
            'tax' => $taxPrice,
            'total' => $subTotal + $taxPrice
        ]);
    }
}
