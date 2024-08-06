<?php

namespace App\Observers;

use App\Models\Commision;
use App\Models\FlowProcess;
use App\Models\FlowSetting;
use Illuminate\Support\Facades\Auth;

class CommissionObserver
{
    /**
     * Handle the Project "updated" event.
     *
     * @param  \App\Models\Commision  $request
     * @return void
     */
    public function updated(Commision $request)
    {
        $before = $request->getOriginal();
        addLog($request, json_encode($request->toArray()), json_encode($before));

        if ($request->status == 'submit') {
            FlowProcess::create([
                'model' => 'COMMISSION',
                'model_id' => $request->id,
                'user_id' => Auth::user()->id,
                'status' => 'submited'
            ]);

            $flow = FlowSetting::where('model', 'COMMISSION')->where('team_id', auth()->user()->currentTeam->id)->get();
            foreach ($flow as $key => $value) {
                FlowProcess::create([
                    'model' => $value->model,
                    'model_id' => $request->id,
                    'role_id' => $value->role_id,
                    'task' => $value->description,
                ]);
            }

            // FlowProcess::create([
            //     'model'     => 'COMMISSION',
            //     'model_id'  => $request->id,
            //     'role_id'   => 1,
            //     'task'      => '1st Approver'
            // ]);
        }

        // if($request->status == 'approved')
        // {
        //     //Releaser
        //     FlowProcess::create([
        //         'model'     => 'COMMISSION',
        //         'model_id'  => $request->id,
        //         'role_id'   => 1,
        //         'task'      => 'Releasor'
        //     ]);
        // }
    }

    public function created(Commision $commission)
    {

        addLog($commission, json_encode($commission->toArray()));
    }



    public function deleted(Commision $commission)
    {
        addLog($commission, null, json_encode($commission->toArray()));
    }
}
