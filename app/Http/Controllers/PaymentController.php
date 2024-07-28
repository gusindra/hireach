<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Quotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    // public $user_info;
    // public function __construct()
    // {


    //     $this->middleware(function ($request, $next) {
    //         // Your auth here
    //         $granted = false;
    //         $user = auth()->user();
    //         $granted = userAccess('PAYMENT');

    //         if ($granted) {
    //             return $next($request);
    //         }
    //         abort(403);
    //     });
    // }

    public function index(Request $request)
    {
        if ($request->has('v')) {
            return view('main-side.payment-deposit');
        }
        return view('payment.deposit');
    }

    public function topup()
    {
        return view('payment.topup');
    }

    public function quotation()
    {

        return view('payment.quotation');
    }
    public function orderUser()
    {

        return view('assistant.invoice.index');
    }

    public function quotationShow($id)
    {
        $data = Quotation::find($id);
        $this->authorize('VIEW_QUOTATION', $data->model_id);
        return view('payment.show-quotation', compact('data'));
    }

    public function invoice(Order $id)
    {
        if (auth()->user()->isClient->uuid != $id->customer_id)
            abort(404);

        return view('payment.pay', ['order' => $id]);
    }


}
