<?php

namespace App\Observers;

use App\Models\Commision;

class CommisionObserver
{
    public function created(Commision $commission)
    {
        addLog($commission, json_encode($commission->toArray()));
    }

    public function updated(Commision $commission)
    {
        $before = $commission->getOriginal();
        addLog($commission, json_encode($commission->toArray()), json_encode($before));
    }

    public function deleted(Commision $commission)
    {
        addLog($commission, null, json_encode($commission->toArray()));
    }
}
