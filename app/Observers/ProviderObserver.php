<?php

namespace App\Observers;

use App\Models\Provider;

class ProviderObserver
{
    public function created(Provider $provider)
    {
        addLog($provider, json_encode($provider->toArray()));
    }

    public function updated(Provider $provider)
    {
        $before = $provider->getOriginal();
        addLog($provider, json_encode($provider->toArray()), json_encode($before));
    }

    public function deleted(Provider $provider)
    {
        addLog($provider, null, json_encode($provider->toArray()));
    }
}
