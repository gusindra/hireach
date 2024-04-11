<?php

namespace App\Observers;

use App\Models\Audience;
use App\Models\AudienceClient;

class AudienceObserver
{
    /**
     * Handle the Audience "created" event.
     *
     * @param  \App\Models\Audience  $audience
     * @return void
     */
    public function created(Audience $audience)
    {
        //
    }

    /**
     * Handle the Audience "updated" event.
     *
     * @param  \App\Models\Audience  $audience
     * @return void
     */
    public function updated(Audience $audience)
    {
        //
    }

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

    /**
     * Handle the Audience "restored" event.
     *
     * @param  \App\Models\Audience  $audience
     * @return void
     */
    public function restored(Audience $audience)
    {
        //
    }

    /**
     * Handle the Audience "force deleted" event.
     *
     * @param  \App\Models\Audience  $audience
     * @return void
     */
    public function forceDeleted(Audience $audience)
    {
        //
    }
}
