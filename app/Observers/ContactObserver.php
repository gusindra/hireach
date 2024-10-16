<?php

namespace App\Observers;

use App\Models\ClientValidation;
use App\Models\CommerceItem;
use App\Models\Contact;
use App\Models\OrderProduct;
use App\Models\Quotation;
use App\Models\SaldoUser;

class ContactObserver
{
    /**
     * Handle the Contact "created" event.
     *
     * @param  \App\Models\Contact  $contact
     * @return void
     */
    public function created(Contact $contact)
    {
        //
    }

    /**
     * Handle the Contact "updated" event.
     *
     * @param  \App\Models\Contact  $contact
     * @return void
     */
    public function updated(Contact $contact)
    {
        $before = $contact->getOriginal();
        addLog($contact, json_encode($contact->toArray()), json_encode($before));
        //KETIKA UPDATE STATUS RESULT NOKTP, STATUSNO, STATUSWA, ACTIVATIONDATE, GEOLOCATIONTAG, STATUSRECYCLE
        $validation = $contact->clientValidations;
        foreach($validation as $cv){
            $cvalid = false;
            $setprice = true;
            $price = 0;

            if($cv->status==0){
                $cvalid = ClientValidation::find($cv->id);
                $cvupdate = $cvalid->update(['status'=>1]);
                if($cvalid && $setprice){
                    if($cv->type && !empty($contact->no_ktp) && !empty($contact->phone_number)){
                        // KTP TIDAK VALID PRICE  = 0
                        if(!in_array($contact->phone, ["NIK_NOT_VALID", "#N/A", "NO_DATA_FOUND", "NO DATA FOUND", "NIK NOT VALID"])){
                            $price = $cvalid->price;
                        }
                    }elseif($cv->type && !empty($contact->status_no) && !empty($contact->activation_date)){
                        // PHONE TIDAK VALID PRICE  = 0
                        if(!in_array($contact->status_no, ["NOT VALID", "NOT_VALID", "#N/A"])){
                            $price = $cvalid->price;
                        }
                    }elseif($cv->type && !empty($contact->status_wa)){
                        // PHONE TIDAK VALID PRICE  = 0
                        if(!in_array($contact->status_wa, ["NOT VALID", "NOT_VALID", "#N/A"])){
                            $price = $cvalid->price;
                        }
                    }elseif($cv->type && !empty($contact->geolocation_tag)){
                        // PHONE TIDAK VALID PRICE  = 0
                        if(!in_array($contact->geolocation_tag, ["NOT VALID", "NOT_VALID", "#N/A"])){
                            $price = $cvalid->price;
                        }
                    }elseif($cv->type && !empty($contact->status_recycle)){
                        // PHONE TIDAK VALID PRICE  = 0
                        if(!in_array($contact->status_recycle, ["NOT VALID", "NOT_VALID", "#N/A"])){
                            $price = $cvalid->price;
                        }
                    }
                }
                if($price == 0){
                    $this->addSaldo($cvalid->price, $cv);
                }
            }
        }
    }

    /**
     * Handle the Contact "deleted" event.
     *
     * @param  \App\Models\Contact  $contact
     * @return void
     */
    public function deleted(Contact $contact)
    {
        //
    }

    /**
     * Handle the Contact "restored" event.
     *
     * @param  \App\Models\Contact  $contact
     * @return void
     */
    public function restored(Contact $contact)
    {
        //
    }

    /**
     * Handle the Contact "force deleted" event.
     *
     * @param  \App\Models\Contact  $contact
     * @return void
     */
    public function forceDeleted(Contact $contact)
    {
        //
    }

    /**
     * addSaldo is function to reduction balance user /
     *
     * @param  mixed $price
     * @param  mixed $request
     * @param  mixed $currency
     * @return void
     */
    private function addSaldo($price, $request, $currency = 'idr')
    {
        SaldoUser::create([
            'team_id'       => NULL,
            'model_id'      => $request->id,
            'model'         => 'ClientValidation',
            'currency'      => $currency,
            'amount'        => $price,
            'mutation'      => 'credit',
            'description'   => 'Cost - ' . $request->id . ' - ' . $request->type,
            'user_id'       => $request->user_id,
        ]);
    }
}
