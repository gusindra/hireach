<?php

namespace App\Observers;

use App\Jobs\ProcessEmail;
use App\Models\Notice;
use App\Models\SaldoUser;
use Illuminate\Support\Facades\Log;

class SaldoUserObserver
{
    /**
     * Handle the SaldoUser "created" event.
     *
     * @param  SaldoUser  $request
     * @return void
     */
    public function created(SaldoUser $request)
    {
        Log::debug($request);
        $last = SaldoUser::where('id', '!=', $request->id)->where('user_id', $request->user_id)->where('team_id', $request->team_id)->orderBy('id', 'desc')->first();
        Log::debug($last);
        if ($last) {
            $amount = $last->balance + $request->amount;
            if ($request->mutation == 'debit') {
                $amount = $last->balance - $request->amount;
            }
            $request->update(['balance' => $amount]);
        } else {
            $request->update(['balance' => $request->amount]);
        }

        if ($request->mutation == 'debit') {
            $notif_count = Notice::where('model', 'Balance')->where('user_id', $request->user_id)->count();
            if (($notif_count == 1 && $request->balance <= 50000) || ($notif_count == 0 && $request->balance <= 100000)) {
                $notif = Notice::create([
                    'type'          => 'email',
                    'model_id'      => $request->id,
                    'model'         => 'Balance',
                    'notification'  => 'Balance Alert. Your current balance remaining '.$request->currency.'.'. number_format($request->balance),
                    'user_id'       => $request->user_id,
                    'status'        => 'unread',
                ]);

                if ($notif) {
                    ProcessEmail::dispatch($request, 'alert_balance');
                }
            }
        }
        if ($request->mutation == 'credit') {
            Notice::where('type', 'email')->where('model', 'Balance')->where('user_id', $request->user_id)->delete();
        }

        if ($request->mutation == 'credit') {

            Notice::create([
                'type' => 'Top Up',
                'model_id' => $request->id,
                'model' => 'Balance',
                'notification' => 'Top Up Successed your balance now '.$request->currency.'.'. number_format($request->balance),
                'user_id' =>  $request->user_id,
                'status' => 'unread'
            ]);
        }
    }

    /**
     * Handle the SaldoUser "deleted" event.
     *
     * @param  SaldoUser $request
     * @return void
     */
    public function deleted()
    {
        //
    }
}
