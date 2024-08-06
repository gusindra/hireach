<?php

namespace App\Observers;

use App\Models\TeamUser;
use App\Models\User;

class TeamUserObserver
{
    /**
     * Handle the Request "created" event.
     *
     * @param  TeamUser  $request
     * @return void
     */
    public function updated(TeamUser $request)
    {
        // if status update syn to user :
        if($request->status == null){
            $request = User::find($request->user_id)->update(['status'=>$request->status]);
        }
    }

}


