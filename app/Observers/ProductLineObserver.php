<?php

namespace App\Observers;

use App\Models\ProductLine;

class ProductLineObserver
{
    public function created(ProductLine $productLine)
    {
        addLog($productLine, json_encode($productLine->toArray()));
    }

    public function updated(ProductLine $productLine)
    {
        $before = $productLine->getOriginal();
        addLog($productLine, json_encode($productLine->toArray()), json_encode($before));
    }

    public function deleted(ProductLine $productLine)
    {
        addLog($productLine, null, json_encode($productLine->toArray()));
    }
}
