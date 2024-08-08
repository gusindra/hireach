<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Str;

class UserBillingController extends Controller
{
    public $user_info;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // Your auth here
            $this->user_info=auth()->user()->super->first();
            if($this->user_info && $this->user_info->role=='superadmin'){
                return $next($request);
            }
            abort(404);
        });
    }

    public function index()
    {
        return view('billing-table');
    }

    public function generate()
    {
        return redirect()->to("/user-billing");
    }

    /**
     * invoice
     *
     * @param  Illuminate\Http\Request $request
     * @return void
     */
    public function invoice(Request $request)
    {
        Billing::create([
            'uuid'          => Str::uuid(),
            'status'        => $request->status,
            'code'          => $request->code,
            'description'   => $request->description,
            'amount'        => $request->amount,
            'user_id'       => $request->user_id,
            'period'        => $request->period,
        ]);
        return redirect()->back();
    }

    /**
     * showInvoice
     *
     * @param  App\Models\Billing $billing
     * @return \Illuminate\Contracts\View\View
     */
    public function showInvoice(Billing $billing)
    {
        $user = User::find($billing->user_id);
        return view('detail-invoice', ['billing'=>$billing, 'user'=>$user]);

    }

    /**
     * updateInvoice
     *
     * @param  App\Models\Billing $billing
     * @param  Illuminate\Http\Request $request
     * @return void
     */
    public function updateInvoice(Billing $billing, Request $request)
    {
        // return $billing;
        // return $request;
        $billing->update([
            'status'        => $request->status,
            'code'          => $request->code,
            'period'        => $request->period,
            'description'   => $request->description,
            'amount'        => $request->amount,
        ]);
        return redirect()->back();
    }
}
