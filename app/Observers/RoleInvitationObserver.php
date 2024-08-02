<?php

namespace App\Observers;

use App\Models\RoleInvitation;
use Illuminate\Support\Facades\Auth;

class RoleInvitationObserver
{
    /**
     * Handle the RoleInvitation "created" event.
     *
     * @param  \App\Models\RoleInvitation  $roleInvitation
     * @return void
     */
    public function created(RoleInvitation $roleInvitation)
    {
        addLog($roleInvitation, json_encode($roleInvitation->toArray()));
    }

    /**
     * Handle the RoleInvitation "updated" event.
     *
     * @param  \App\Models\RoleInvitation  $roleInvitation
     * @return void
     */
    public function updated(RoleInvitation $roleInvitation)
    {
        $original = json_encode($roleInvitation->getOriginal());
        $current = json_encode($roleInvitation->getAttributes());
        addLog($roleInvitation, $current, $original);
    }

    /**
     * Handle the RoleInvitation "deleted" event.
     *
     * @param  \App\Models\RoleInvitation  $roleInvitation
     * @return void
     */
    public function deleted(RoleInvitation $roleInvitation)
    {
        addLog($roleInvitation, null, json_encode($roleInvitation->getOriginal()));
    }
}
