<?php

namespace App\Http\Controllers;

use App\Models\Billing;

class InvoiceController extends Controller
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

    public function index()
    {
        return view('assistant.order.invoice');
    }

    public function show(Billing $invoice)
    {

        return view('assistant.invoice.show', ['invoice' => $invoice, 'order' => $invoice->order]);
    }
}
