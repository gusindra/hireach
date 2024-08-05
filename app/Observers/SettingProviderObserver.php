<?php

namespace App\Observers;

use App\Models\SettingProvider;

class SettingProviderObserver
{
    public function created(SettingProvider $settingProvider)
    {
        addLog($settingProvider, json_encode($settingProvider->toArray()));
    }

    public function updated(SettingProvider $settingProvider)
    {
        $before = $settingProvider->getOriginal();
        addLog($settingProvider, json_encode($settingProvider->toArray()), json_encode($before));
    }

    public function deleted(SettingProvider $settingProvider)
    {
        addLog($settingProvider, null, json_encode($settingProvider->toArray()));
    }
}
