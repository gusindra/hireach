<?php

namespace App\Observers;

use App\Models\CommerceItem;
use App\Models\Provider;
use App\Models\ProviderUser;

class CommerceItemObserver
{
    public function created(CommerceItem $commerceItem)
    {
        addLog($commerceItem, json_encode($commerceItem->toArray()));
    }

    public function updated(CommerceItem $commerceItem)
    {
        $before = $commerceItem->getOriginal();
        addLog($commerceItem, json_encode($commerceItem->toArray()), json_encode($before));

        if ($commerceItem->isDirty('sku')) {
            $newSku = $commerceItem->sku;


            $providers = Provider::all();
            foreach ($providers as $provider) {
                $channels = explode(',', $provider->channel);
                if (count($channels) === 2 && $channels[1] === $before['sku']) {
                    $channels[1] = $newSku;
                    $provider->channel = implode(',', $channels);
                    $provider->save();
                }
            }


            $providerUsers = ProviderUser::all();
            foreach ($providerUsers as $providerUser) {
                if ($providerUser->channel === $before['sku']) {
                    $providerUser->channel = $newSku;
                    $providerUser->save();
                }
            }
        }
    }


    public function deleted(CommerceItem $commerceItem)
    {
        addLog($commerceItem, null, json_encode($commerceItem->toArray()));
    }
}
