<?php

namespace App\Observers;

use App\Models\Notice;

class NoticeObserver
{
    public function created(Notice $notice)
    {
        addLog($notice, json_encode($notice->toArray()));
    }

    public function updated(Notice $notice)
    {
        $before = $notice->getOriginal();
        addLog($notice, json_encode($notice->toArray()), json_encode($before));
    }

    public function deleted(Notice $notice)
    {
        addLog($notice, null, json_encode($notice->toArray()));
    }
}
