<?php

namespace App\Observers;

use App\Models\BlastMessage;
use App\Models\CampaignModel;
use App\Models\OperatorPhoneNumber;
use App\Models\OrderProduct;
use App\Models\ProductLine;
use App\Models\Quotation;
use App\Models\SaldoUser;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SmsBlastObserver
{
    /**
     * Handle the SaldoUser "created" event.
     *
     * @param  BlastMessage  $request
     * @return void
     */
    public function created(BlastMessage $request)
    {

        if ($request->code == "200") {
            $set_price = 0;
            //check logic quotation for sms active here
            if ($quote = Quotation::where('model', 'USER')->where('model_id', $request->user_id)->whereIn('status', ['reviewed','active'])->orderBy('id', 'desc')->first()) {
                //get price for sms
                $items = OrderProduct::orderBy('id', 'asc')->where('model', 'Quotation')->where('model_id', $quote->id)->get();
                //FIND WAY TO FILTER BY PHONE NUMBER BASE ON OPERATOR
                $phoneNo = $request->msisdn;
                $phoneNo = substr($phoneNo, 0, 5);
                $opn = OperatorPhoneNumber::where('code', $phoneNo)->first();
                foreach ($items as $product) {
                    // IF NON OTP
                    if ($request->otp == 0) {
                        if ($opn && $opn->operator == $product->name) {
                            $this->addSaldo($product, $request);
                            $set_price = 1;
                            // Log::debug('hit non otp single operator');
                        } elseif (Str::contains($product->name, 'SMS NON OTP') || Str::contains($product->name, 'HR-NSO')) {
                            // Default by key SMS NON OTP
                            $this->addSaldo($product, $request);
                            $set_price = 1;
                            // Log::debug('hit non otp all operator');
                        } elseif (Str::contains($product->name, 'HR-SLC')) {
                            // Default by key SMS NON OTP
                            $this->addSaldo($product, $request);
                            $set_price = 1;
                            // Log::debug('hit non otp all operator');
                        } elseif (Str::contains($product->name, 'HR-WLC')) {
                            // Default by key SMS NON OTP
                            $this->addSaldo($product, $request);
                            $set_price = 1;
                            // Log::debug('hit non otp all operator');
                        } elseif (Str::contains($product->name, 'HR-EML1')) {
                            // Default by key SMS NON OTP
                            $this->addSaldo($product, $request);
                            $set_price = 1;
                            // Log::debug('hit non otp all operator');
                        } elseif (Str::contains($product->name, 'HR-EMLO')) {
                            // Default by key SMS NON OTP
                            $this->addSaldo($product, $request);
                            $set_price = 1;
                            // Log::debug('hit non otp all operator');
                        }
                    } elseif ($request->otp == 1) {
                        //FIND WAY TO FILTER BY PHONE NUMBER BASE ON OPERATOR
                        if ($opn && $opn->operator == $product->name) {
                            $this->addSaldo($product, $request);
                            $set_price = 1;
                            // Log::debug('hit otp single operator');
                        } elseif (Str::contains($product->name, 'SMS OTP') || Str::contains($product->name, 'HR-SO')) {
                            $this->addSaldo($product, $request);
                            $set_price = 1;
                            // Log::debug('hit otp single operator');
                        } elseif (Str::contains($product->name, 'HR-EML1')) {
                            // Default by key SMS NON OTP
                            $this->addSaldo($product, $request);
                            $set_price = 1;
                            // Log::debug('hit non otp all operator');
                        } elseif (Str::contains($product->name, 'HR-EMLO')) {
                            // Default by key SMS NON OTP
                            $this->addSaldo($product, $request);
                            $set_price = 1;
                            // Log::debug('hit non otp all operator');
                        }
                    }
                }
            } else {
                //else run this price
                $master = ProductLine::where('name', 'HiReach')->first();
                $items = $master->items;

                //check msisdn for $product items
                // CHARGE BY PRODUCT PRICE
                if (count($items) > 0) {
                    foreach ($items as $product) {
                        if (str_contains($request->sender_id, $product->sku)) {
                            $this->addSaldo($product, $request);
                            $set_price = 1;
                        }
                        //}else{
                        // CHECK SMS BY PHONE NUMBER
                        //$b = explode(",",$product->spec);
                        //$p = $request->msisdn;
                        //if(count($b)>0){
                        //    foreach($b as $bs){
                        //        if (strpos($p, $bs) !== false) {
                        // Log::debug($product);
                        // Log::debug($bs);
                        //            $this->addSaldo($product, $request);
                        //            $set_price = 1;
                        //        }
                        //   }
                        //}
                        //}
                    }
                }
            }

            //IF THEREIS NO BALANCE UPDATE DEFAULT BY SMS PRICE
            if ($set_price == 0) {
                $this->addSaldo($request, $request, $request->currency);
            }
        }

        //PUSH to Campaign
    }

    private function addSaldo($product, $request, $currency = 'IDR')
    {
        SaldoUser::create([
            'team_id'       => NULL,
            'model_id'      => $request->id,
            'model'         => 'BlastMessage',
            'currency'      => "IDR",
            'amount'        => $product->price,
            'mutation'      => 'debit',
            'description'   => 'Cost: '.$product->name. ' - Msg:' . $request->id . ' - ' . $request->msg_id,
            'user_id'       => $request->user_id,
        ]);
    }
    /**
     * Handle the SaldoUser "created" event.
     *
     * @param  \App\Models\Request  $request
     * @return void
     */
    public function updated(BlastMessage $request)
    {
        if ($request->code == "200") {
            Log::debug('in to 200');
            if (strtolower($request->status) == 'accepted' || strtolower($request->status) == 'success') {
                $set_price = 0;
                //check logic quotation for sms active here
                if ($quote = Quotation::where('model', 'USER')->where('model_id', $request->user_id)->whereIn('status', ['reviewed','active'])->orderBy('id', 'desc')->first()) {
                    Log::debug('in to quotation price');

                    //get price for sms
                    $items = OrderProduct::orderBy('id', 'asc')->where('model', 'Quotation')->where('model_id', $quote->id)->get();
                    //FIND WAY TO FILTER BY PHONE NUMBER BASE ON OPERATOR
                    $phoneNo = $request->msisdn;
                    $phoneNo = substr($phoneNo, 0, 5);
                    $opn = OperatorPhoneNumber::where('code', $phoneNo)->first();
                    foreach ($items as $product) {
                        Log::debug($product);

                        // IF NON OTP
                        if ($request->otp == 0) {
                            Log::debug('in to non otp price');
                            if ($opn && $opn->operator == $product->name) {
                                $this->addSaldo($product, $request);
                                $set_price = 1;
                                // Log::debug('hit non otp single operator');
                            } elseif (Str::contains($product->name, 'SMS NON OTP') || Str::contains($product->name, 'HR-NSO')) {
                                // Default by key SMS NON OTP
                                $this->addSaldo($product, $request);
                                $set_price = 1;
                                // Log::debug('hit non otp all operator');
                            } elseif (Str::contains($product->name, 'HR-SLC')) {
                                // Default by key SMS NON OTP
                                $this->addSaldo($product, $request);
                                $set_price = 1;
                                // Log::debug('hit non otp all operator');
                            } elseif (Str::contains($product->name, 'HR-WLC')) {
                                // Default by key SMS NON OTP
                                $this->addSaldo($product, $request);
                                $set_price = 1;
                                // Log::debug('hit non otp all operator');
                            } elseif (Str::contains($product->name, 'HR-EML1')) {
                                // Default by key SMS NON OTP
                                $this->addSaldo($product, $request);
                                $set_price = 1;
                                // Log::debug('hit non otp all operator');
                            } elseif (Str::contains($product->name, 'HR-EMLO')) {
                                // Default by key SMS NON OTP
                                $this->addSaldo($product, $request);
                                $set_price = 1;
                                // Log::debug('hit non otp all operator');
                            }
                        } elseif ($request->otp == 1) {
                            Log::debug('in to otp price');
                            //FIND WAY TO FILTER BY PHONE NUMBER BASE ON OPERATOR
                            if ($opn && $opn->operator == $product->name) {
                                $this->addSaldo($product, $request);
                                $set_price = 1;
                                // Log::debug('hit otp single operator');
                            } elseif (Str::contains($product->name, 'SMS OTP') || Str::contains($product->name, 'HR-SO')) {
                                $this->addSaldo($product, $request);
                                $set_price = 1;
                                // Log::debug('hit otp single operator');
                            } elseif (Str::contains($product->name, 'HR-EML1')) {
                                // Default by key SMS NON OTP
                                $this->addSaldo($product, $request);
                                $set_price = 1;
                                // Log::debug('hit non otp all operator');
                            } elseif (Str::contains($product->name, 'HR-EMLO')) {
                                // Default by key SMS NON OTP
                                $this->addSaldo($product, $request);
                                $set_price = 1;
                                // Log::debug('hit non otp all operator');
                            }
                        }
                    }
                } else {
                    Log::debug('in to product line price');
                    //else run this price
                    $master = ProductLine::where('name', 'HiReach')->first();
                    $items = $master->items;

                    //check msisdn for $product items
                    // CHARGE BY PRODUCT PRICE
                    if (count($items) > 0) {
                        foreach ($items as $product) {
                            if (str_contains($request->sender_id, $product->sku)) {
                                $this->addSaldo($product->unit_price, $request);
                                $set_price = 1;
                            }
                            //}else{
                            // CHECK SMS BY PHONE NUMBER
                            //$b = explode(",",$product->spec);
                            //$p = $request->msisdn;
                            //if(count($b)>0){
                            //    foreach($b as $bs){
                            //        if (strpos($p, $bs) !== false) {
                            // Log::debug($product);
                            // Log::debug($bs);
                            //            $this->addSaldo($product->unit_price, $request);
                            //            $set_price = 1;
                            //        }
                            //   }
                            //}
                            //}
                        }
                    }
                }

                //IF THEREIS NO BALANCE UPDATE DEFAULT BY SMS PRICE
                if ($set_price == 0) {
                    $this->addSaldo($request, $request, $request->currency);
                }
            }
        }
    }

    /**
     * Handle the SaldoUser "deleted" event.
     *
     * @param  \App\SaldoUser  $request
     * @return void
     */
    public function deleted()
    {
        //
    }
}
