<?php

namespace App\Observers;

use App\Models\Company;

class CompanyObserver
{
    public function created(Company $company)
    {
        addLog($company, json_encode($company->toArray()));
    }

    public function updated(Company $company)
    {
        $before = $company->getOriginal();
        addLog($company, json_encode($company->toArray()), json_encode($before));
    }

    public function deleted(Company $company)
    {
        addLog($company, null, json_encode($company->toArray()));
    }
}
