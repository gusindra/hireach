<?php

namespace App\Observers;

use App\Models\ProviderUser;

class ProviderUserObserver
{
    public function created(ProviderUser $providerUser)
    {

        addLog($providerUser, json_encode($providerUser->toArray()));
    }

    public function updated(ProviderUser $providerUser)
    {
        $before = $providerUser->getOriginal();
        addLog($providerUser, json_encode($providerUser->toArray()), json_encode($before));
    }

    public function deleted(ProviderUser $providerUser)
    {
        addLog($providerUser, null, json_encode($providerUser->toArray()));
    }
}
