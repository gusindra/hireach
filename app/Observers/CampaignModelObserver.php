<?php

namespace App\Observers;

use App\Models\CampaignModel;

class CampaignModelObserver
{
    /**
     * Handle the Request "created" event.
     *
     * @param  CampaignModel  $request
     * @return void
     */
    public function created(CampaignModel $request)
    {
            if($request->model=='BlastMessage'){
                $message = $request->blast;
            }else{
                $message = $request->message;
            }

            if($request->campaign->campaign->audience->lastClient == $message->client_id){
                if($request->campaign->loop_type == 0){
                    $request->campaign->update([
                        'status' => 'finished'
                    ]);
                }
            }
    }

    /**
     * updated
     *
     * @param  CampaignModel $request
     * @return void
     */
    public function updated(CampaignModel $request)
    {
        //
    }

    /**
     * Handle the Template "deleted" event.
     *
     * @param  CampaignModel  $request
     * @return void
     */
    public function deleted(CampaignModel $request)
    {
        //
    }
}
