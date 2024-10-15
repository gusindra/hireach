<?php

namespace App\Observers;

use App\Models\ClientValidation;

class ClientValidationObserver
{
    /**
     * Handle the ClientValidation "created" event.
     *
     * @param  \App\Models\ClientValidation  $clientValidation
     * @return void
     */
    public function created(ClientValidation $clientValidation)
    {
        //PROCESS PENGURANGAN SALDO KETIKA PEMBUATAN DATA JIKA CONTACT SUDAH VALID
        
    }

    /**
     * Handle the ClientValidation "updated" event.
     *
     * @param  \App\Models\ClientValidation  $clientValidation
     * @return void
     */
    public function updated(ClientValidation $clientValidation)
    {
        $before = $clientValidation->getOriginal();
        addLog($clientValidation, json_encode($clientValidation->toArray()), json_encode($before));
    }

    /**
     * Handle the ClientValidation "deleted" event.
     *
     * @param  \App\Models\ClientValidation  $clientValidation
     * @return void
     */
    public function deleted(ClientValidation $clientValidation)
    {
        addLog($clientValidation, null, json_encode($clientValidation->toArray()));
    }
    /**
     * Handle the ClientValidation "restored" event.
     *
     * @param  \App\Models\ClientValidation  $clientValidation
     * @return void
     */
    public function restored(ClientValidation $clientValidation)
    {
        //
    }

    /**
     * Handle the ClientValidation "force deleted" event.
     *
     * @param  \App\Models\ClientValidation  $clientValidation
     * @return void
     */
    public function forceDeleted(ClientValidation $clientValidation)
    {
        //
    }
}
