<?php

namespace App\Observers;

use App\Models\CompanyPayment;

class CompanyPaymentObserver
{
    public function created(CompanyPayment $companyPayment)
    {
        addLog($companyPayment, json_encode($companyPayment->toArray()));
    }

    public function updated(CompanyPayment $companyPayment)
    {
        $before = $companyPayment->getOriginal();
        addLog($companyPayment, json_encode($companyPayment->toArray()), json_encode($before));
    }

    public function deleted(CompanyPayment $companyPayment)
    {
        addLog($companyPayment, null, json_encode($companyPayment->toArray()));
    }
}
