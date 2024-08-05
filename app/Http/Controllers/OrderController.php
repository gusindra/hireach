<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Quotation;
use App\Models\User;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class OrderController extends Controller
{
    public $user_info;
    public function __construct()
    {

        // $this->middleware(function ($request, $next) {
        //     // Your auth here
        //     $granted = false;
        //     $user = auth()->user();
        //     $granted = userAccess('ORDER');

        //     if ($granted) {
        //         return $next($request);
        //     }
        //     abort(403);
        // });
    }


    public function index()
    {
        return view('assistant.order.index');
    }

    public function invoice()
    {
        return view('assistant.order.invoice');
    }

    public function quotation()
    {
        return view('assistant.commercial.quotation.index');
    }

    public function showQuotation(Quotation $quotation)
    {

        return view('assistant.commercial.quotation.show', ['quote' => $quotation]);
    }

    public function show(Order $order)
    {
        return view('assistant.order.show', ['order' => $order]);
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
