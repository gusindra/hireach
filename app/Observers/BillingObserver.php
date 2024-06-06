<?php

namespace App\Observers;

use App\Models\Billing;
use App\Models\Commision;
use App\Models\FlowProcess;
use App\Models\FlowSetting;
use Illuminate\Support\Str;

class BillingObserver
{
    /**
     * Handle the Request "created" event.
     *
     * @param  \App\Models\Billing  $request
     * @return void
     */
    public function created(Billing $request)
    {
    }

    /**
     * Handle the Project "updated" event.
     *
     * @param  \App\Models\Billing  $request
     * @return void
     */
    public function updated(Billing $request)
    {
        if ($request->status == 'paid') {
            $request->order->update([
                'status'    => 'paid'
            ]);
            if ($request->commission) {
                $total = $request->commission->type == "price" ? $request->commission->ratio : $request->commission->ratio / 100 * $request->bill->amount;
                Commision::find($request->id)->update([
                    'total'     => $total,
                    'status'    => 'unpaid'
                ]);
            }
        }

        if ($request->status == 'approved') {
            //
        }
    }

    /**
     * Handle the Client "deleted" event.
     *
     * @param  \App\Models\Billing $request
     * @return void
     */
    public function deleted()
    {
        //
    }
}
