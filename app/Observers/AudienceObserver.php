<?php

namespace App\Observers;

use App\Models\Audience;
use App\Models\AudienceClient;

class AudienceObserver
{
    /**
     * Handle the Audience "deleted" event.
     *
     * @param  \App\Models\Audience  $audience
     * @return void
     */
    public function deleted(Audience $audience)
    {
        AudienceClient::where('audience_id', $audience->id)->delete();
    }
}
