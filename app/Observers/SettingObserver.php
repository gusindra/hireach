<?php

namespace App\Observers;

use App\Models\Setting;

class SettingObserver
{
    public function created(Setting $setting)
    {
        addLog($setting, json_encode($setting->toArray()));
    }

    public function updated(Setting $setting)
    {
        $before = $setting->getOriginal();
        addLog($setting, json_encode($setting->toArray()), json_encode($before));
    }

    public function deleted(Setting $setting)
    {
        addLog($setting, null, json_encode($setting->toArray()));
    }
}
