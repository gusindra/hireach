<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\Billing;
use App\Models\Commision;
use App\Models\FlowProcess;
use App\Models\FlowSetting;
use App\Models\Notice;
use App\Models\OrderProduct;
use App\Models\SaldoUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class OrderObserver
{
    /**
     * Handle the Project "created" event.
     *
     * @param  \App\Models\Request  $request
     * @return void
     */
    public function created(Order $request)
    {
        if ($request->status == 'unpaid') {
            Billing::create([
                'uuid'          => Str::uuid(),
                'status'        => $request->status,
                'code'          => $request->no,
                'description'   => $request->name,
                'amount'        => $request->total,
                'user_id'       => $request->user_id,
                'order_id'      => $request->id,
                'period'        => $request->date->format('m/Y')
            ]);
        }


    }

    /**
     * Handle the Project "updated" event.
     *
     * @param  \App\Models\Request  $request
     * @return void
     */
    public function updated(Order $request)
    {

        //Log::debug($request->status);
        if ($request->status == 'unpaid') {
            $bill = Billing::where('order_id', $request->id)->get();
            // $order = Order::where('customer_id', $request->id)->get();
            if (count($bill) == 0) {
                Billing::create([
                    'uuid'          => Str::uuid(),
                    'status'        => $request->status,
                    'code'          => $request->no,
                    'description'   => $request->name,
                    'amount'        => $request->total,
                    'user_id'       => $request->user_id,
                    'order_id'      => $request->id,
                    'period'        => $request->date->format('Y-m-d')
                ]);
            }

            Notice::create([
                'type'          => 'Invoice',
                'model_id'      => $request->id,
                'model'         => 'Order',
                'notification'  => 'Please paid your order invoice',
                'user_id'       => $request->customer_id,
                'status'        => 'unread',
            ]);
        } elseif ($request->status == 'paid') {
            // $request->bill->update([
            //     'status'    => 'paid'
            // ]);
            // Log::debug($request->commission);
            // if($request->commission){
            //     $total = $request->commission->type == "price" ? $request->commission->ratio : $request->commission->ratio/100 * $request->bill->amount;
            //     Commision::find($request->commission->id)->update([
            //         'total'     => $total,
            //         'status'    => 'unpaid'
            //     ]);
            // }

            $user = User::where('email', $request->customer->email)->first();
            if ($user) {
                $currentSaldo = SaldoUser::where('user_id', $user->id)->latest()->first();

                SaldoUser::create([
                    'user_id' => $user->id,
                    'team_id' => null,
                    'model_id' => $request->id,
                    'model' => 'Order',
                    'mutation' => 'credit',
                    'description' => 'Auto Topup from Order Successfully',
                    'currency' => 'IDR',
                    'amount' => $request->total,
                    'balance' => $currentSaldo && $currentSaldo->amount ? $currentSaldo->amount + $request->total : $request->total
                ]);
            }
        } elseif ($request->status == 'submit') {
            FlowProcess::create([
                'model'     => 'ORDER',
                'model_id'  => $request->id,
                'user_id'   => Auth::user()->id,
                'status'    => 'submited'
            ]);

            $flow = FlowSetting::where('model', 'ORDER')->where('team_id', auth()->user()->currentTeam->id)->get();
            foreach ($flow as $key => $value) {
                FlowProcess::create([
                    'model'     => $value->model,
                    'model_id'  => $request->id,
                    'role_id'   => $value->role_id,
                    'task'      => $value->description,
                ]);
            }

            // FlowProcess::create([
            //     'model'     => 'ORDER',
            //     'model_id'  => $request->id,
            //     'role_id'   => 1,
            //     'task'      => '1st Approver'
            // ]);
        }

        // if($request->status == 'approved')
        // {
        //     FlowProcess::create([
        //         'model'     => 'ORDER',
        //         'model_id'  => $request->id,
        //         'role_id'   => 1,
        //         'task'      => 'Releasor'
        //     ]);
        // }
        if ($request->status == 'approved') {
            Order::find($request->id)->update([
                'status'    => 'unpaid'
            ]);
        }

        $orderProducts = OrderProduct::where('model_id', $request->id)->get();
        if ($request->type == 'topup') {

            OrderProduct::updateOrCreate(
                [
                    'model' => 'Order',
                    'model_id' => $request->id,
                    'name' => 'Topup'
                ],
                [
                    'qty' => 1,
                    'unit' => 1,
                    'price' => $request->total,
                    'note' => 'Topup',
                    'user_id' => 0,
                ]
            );

            // Membuat atau memperbarui OrderProduct Tax
            OrderProduct::updateOrCreate(
                [
                    'model' => 'Order',
                    'model_id' => $request->id,
                    'name' => 'Tax'
                ],
                [
                    'qty' => 1,
                    'unit' => 1,
                    'price' => $request->total * (11 / 100),
                    'note' => 'VAT/PPN @ 11%',
                    'user_id' => 0,
                ]
            );
        }


    }

    /**
     * Handle the Project "deleted" event.
     *
     * @param  Order  $request
     * @return void
     */
    public function deleted(Order $request)
    {
        $bill = Billing::where('order_id', $request->order_id)->delete();
    }
}
