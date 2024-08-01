<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function created(User $user)
    {
        addLog($user, json_encode($user->toArray()));
    }

    public function updated(User $user)
    {
        $before = $user->getOriginal();
        addLog($user, json_encode($user->toArray()), json_encode($before));
    }

    public function deleted(User $user)
    {
        addLog($user, null, json_encode($user->toArray()));
    }
}
