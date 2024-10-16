<?php

namespace App\Observers;

use App\Models\ClientValidation;
use App\Models\CommerceItem;
use App\Models\OrderProduct;
use App\Models\Quotation;
use App\Models\SaldoUser;
use Illuminate\Support\Facades\Log;

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
        $cvalid = false;
        $setprice = true;
        $price = '';
        //==========================
        // PRICE BASE ON QUOTATION
        //==========================
        if ($quote = Quotation::where('model_id', $clientValidation->user_id)->where('model', 'USER')->whereIn('status', ['reviewed','approved'])->orderBy('id', 'desc')->first()) {
            // =================================================================================================
            // GET PRICE FOR WA
            // =================================================================================================
            $items = OrderProduct::orderBy('id', 'asc')->where('model', 'Quotation')->where('model_id', $quote->id)->get();
            foreach($items as $item){
                if($item->product && $item->product->sku == $clientValidation->type){
                    if($clientValidation->type == "HR-DST" && $clientValidation->type==$item->product->sku && !empty($clientValidation->contact->no_ktp) && !empty($clientValidation->contact->phone_number)){
                        if(in_array($clientValidation->contact->no_ktp, ["NIK_NOT_VALID", "#N/A"])){
                            $price = 0;
                        }else{
                            $price = $item->price;
                        }
                        $setprice = false;
                    }elseif($clientValidation->type == "HR-CNV" && $clientValidation->type==$item->product->sku && !empty($clientValidation->contact->status_no)  && !empty($clientValidation->contact->activation_date)){
                        if(in_array($clientValidation->contact->status_no, ["NOT_VALID", "#N/A"])){
                            $price = 0;
                        }else{
                            $price = $item->price;
                        }
                        $setprice = false;
                    }elseif($clientValidation->type == "HR-WAS" && $clientValidation->type==$item->product->sku && !empty($clientValidation->contact->status_wa)){
                        if(in_array($clientValidation->contact->status_wa, ["NOT_VALID", "#N/A"])){
                            $price = 0;
                        }else{
                            $price = $item->price;
                        }
                        $setprice = false;
                    }elseif($clientValidation->type == "HR-GLT" && $clientValidation->type==$item->product->sku && !empty($clientValidation->contact->geolocation_tag)){
                        if(in_array($clientValidation->contact->geolocation_tag, ["NOT_VALID", "#N/A"])){
                            $price = 0;
                        }else{
                            $price = $item->price;
                        }
                        $setprice = false;
                    }elseif($clientValidation->type == "HR-NRS" && $clientValidation->type==$item->product->sku && !empty($clientValidation->contact->status_recycle)){
                        if(in_array($clientValidation->contact->status_recycle, ["NOT_VALID", "#N/A"])){
                            $price = 0;
                        }else{
                            $price = $item->price;
                        }
                        $setprice = false;
                    }
                }
            }
        }
        //==========================
        // PRICE BASE ON BASIC
        //==========================
        if($setprice){
            $price = CommerceItem::where('sku', $clientValidation->type)->first()->unit_price;
            if($clientValidation->type == "HR-DST" && !empty($clientValidation->contact->no_ktp) && !empty($clientValidation->contact->phone_number)){
                if(in_array($clientValidation->contact->no_ktp, ["NIK_NOT_VALID", "#N/A"])){
                    $price = 0;
                }
                $setprice = false;
            }elseif($clientValidation->type == "HR-CNV" && !empty($clientValidation->contact->status_no)  && !empty($clientValidation->contact->activation_date)){
                if(in_array($clientValidation->contact->status_no, ["NOT_VALID", "#N/A"])){
                    $price = 0;
                }
                $setprice = false;
            }elseif($clientValidation->type == "HR-WAS" && !empty($clientValidation->contact->status_wa)){
                if(in_array($clientValidation->contact->status_wa, ["NOT_VALID", "#N/A"])){
                    $price = 0;
                }
                $setprice = false;
            }elseif($clientValidation->type == "HR-GLT" && !empty($clientValidation->contact->geolocation_tag)){
                if(in_array($clientValidation->contact->geolocation_tag, ["NOT_VALID", "#N/A"])){
                    $price = 0;
                }
                $setprice = false;
            }elseif($clientValidation->type == "HR-NRS" && !empty($clientValidation->contact->status_recycle)){
                if(in_array($clientValidation->contact->status_recycle, ["NOT_VALID", "#N/A"])){
                    $price = 0;
                }
                $setprice = false;
            }
        }

        // Log::debug($price);
        $dataCV['price'] = $price;
        // JIKA TRUE MAKA MENUNGGU CONTACT UPDATE
        if($setprice){

        }else{
            // JIKA FALSE MAKA DATA VALID DAN LANGSUNG UBAH STATUS COMPLETE
            $dataCV['status'] = 1;
        }

        $cvalid = ClientValidation::find($clientValidation->id)->update($dataCV);
        if($price){
            $this->addSaldo($price, $clientValidation);
        }
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
            'mutation'      => 'debit',
            'description'   => 'Cost - ' . $request->id . ' - ' . $request->type,
            'user_id'       => $request->user_id,
        ]);
    }
    /**
     * addSaldo is function to reduction balance user /
     *
     * @param  mixed $price
     * @param  mixed $request
     * @param  mixed $currency
     * @return void
     */
    private function subSaldo($price, $request, $currency = 'idr')
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
