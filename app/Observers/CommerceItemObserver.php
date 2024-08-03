<?php

namespace App\Observers;

use App\Models\CommerceItem;

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
    }

    public function deleted(CommerceItem $commerceItem)
    {
        addLog($commerceItem, null, json_encode($commerceItem->toArray()));
    }
}
