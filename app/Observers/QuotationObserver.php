<?php

namespace App\Observers;

use App\Models\Quotation;
use App\Models\FlowProcess;
use App\Models\FlowSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class QuotationObserver
{
    /**
     * Handle the Project "updated" event.
     *
     * @param Quotation $request
     * @return void
     */
    public function updated(Quotation $request)
    {
        if($request->status == 'submit')
        {
            FlowProcess::create([
                'model'     => 'QUOTATION',
                'model_id'  => $request->id,
                'user_id'   => Auth::user()->id,
                'status'    => 'submited'
            ]);

            // FlowProcess::create([
            //     'model'     => 'QUOTATION',
            //     'model_id'  => $request->id,
            //     'role_id'   => 1,
            //     'task'      => '1st Approver'
            // ]);

            // APPROVAL
            $flow = FlowSetting::where('model', 'QUOTATION')->where('team_id', auth()->user()->currentTeam->id)->get();
            foreach($flow as $key => $value){
                FlowProcess::create([
                    'model'     => $value->model,
                    'model_id'  => $request->id,
                    'role_id'   => $value->role_id,
                    'task'      => $value->description,
                ]);
            }
            //Log::debug('create flow '. $flow);
        }

        // foreach($flow as $key => $value){
        //     if($request->status == $value->after_status)
        //     {
        //         FlowProcess::create([
        //             'model'     => $value->model,
        //             'model_id'  => $request->id,
        //             'role_id'   => $value->role_id,
        //             'task'      => $value->description,
        //         ]);
        //     }
        // }

        // if($request->status == 'approved')
        // {
        //     //Releaser
        //     FlowProcess::create([
        //         'model'     => 'quotation',
        //         'model_id'  => $request->id,
        //         'role_id'   => 1,
        //         'task'      => 'Releasor'
        //     ]);
        // }
    }
}
