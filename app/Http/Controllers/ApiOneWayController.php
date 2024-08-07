<?php

namespace App\Http\Controllers;

use App\Http\Resources\CampaignResource;
use App\Http\Resources\OneWayResource;
use App\Http\Resources\SmsResource;
use App\Jobs\importAudienceContact;
use App\Jobs\ProcessCampaignApi;
use App\Models\BlastMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Jobs\ProcessSmsApi;
use App\Jobs\ProcessEmailApi;
use App\Jobs\ProcessWaApi;
use App\Models\ApiCredential;
use App\Models\Audience;
use App\Models\Campaign;
use App\Models\Client;
use App\Models\ProviderUser;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ApiOneWayController extends Controller
{
    /**
     * Set default cache duration
     *
     * @var int
     */
    public $cacheDuration = 1440;

    /**
     * This to get all record made from one way
     *
     * @return json App\Http\Resources\OneWayResource
     */
    public function index(Request $request)
    {
        $skip = $request->page*$request->pageSize;
        $data = BlastMessage::skip($skip)->where('user_id', '=', auth()->user()->id)->take($request->pageSize);
        if($request->order=='id'){
            $data = $data->orderBy('id', 'asc')->get();
        }elseif($request->order=='oldnest'){
            $data = $data->orderBy('created_at', 'asc')->get();
        }elseif($request->order=='newest'){
            $data = $data->orderBy('created_at', 'desc')->get();
        }else{
            $data = $data->get();
        }
        // $data->setPageName('users_per_page');

        return response()->json([
            'code' => 200,
            'message' => "Successful",
            'query' => $request->all(),
            'response' => OneWayResource::collection($data),
        ]);
    }

    /**
     * This to show record filter by phone number
     *
     * @param  mixed $phone
     * @return void
     */
    public function show(Request $request)
    {
        if(is_numeric($request->value)){
            $customer = Client::where('phone', $request->value)->where('user_id', auth()->user()->id)->first();
            if($customer){
                $data = BlastMessage::where('user_id', '=', auth()->user()->id)->where('client_id', $customer->uuid)->get();

                return response()->json([
                    'code' => 200,
                    'message' => "Successful",
                    'response' => SmsResource::collection($data),
                ]);
            }
            return response()->json([
                'code' => 404,
                'message' => "Client not found"
            ]);
        }elseif(strpos($request->value, '@')){
            $customer = Client::where('email', $request->value)->where('user_id', auth()->user()->id)->first();
            if($customer){
                $data = BlastMessage::where('user_id', '=', auth()->user()->id)->where('client_id', $customer->uuid)->get();

                return response()->json([
                    'code' => 200,
                    'message' => "Successful",
                    'response' => SmsResource::collection($data),
                ]);
            }
            return response()->json([
                'code' => 404,
                'message' => "Client not found"
            ]);
        }else{
            $data = Campaign::where('uuid', $request->value)->where('user_id', auth()->user()->id)->first();
            if($data){
                return response()->json([
                    'code' => 200,
                    'message' => "Successful",
                    'response' => CampaignResource::make($data)
                ]);
            }
            return response()->json([
                'code' => 404,
                'message' => "Campaign not found"
            ]);
        }
    }

    /**
     * This to post new request one way
     *
     * @param  mixed $request
     * @return json
     */
    public function post(Request $request)
    {
        //get the request & validate parameters
        $validateArr = [
            'channel'   => 'required',
            'type'      => 'required|numeric',
            'title'     => 'required|string',
            'to'        => 'required|string',
            'provider'  => 'required|string',
            'text'      => 'required|string',
            'detail'    => 'string',
            // 'otp'       => 'boolean'
        ];
        if(strpos( strtolower($request->channel), 'sms' ) !== false){
            $validateArr['from'] = 'alpha_num|required_if:channel,sms_otp_sid|required_if:channel,sms_notp_sid';
        }elseif(strpos( strtolower($request->channel), 'email' ) !== false){
            $validateArr['from'] = 'required';
        }
        $request->validate($validateArr);

        try{
            //$userCredention = ApiCredential::where("user_id", auth()->user()->id)->where("client", "api_sms_mk")->where("is_enabled", 1)->first();
            //Log::channel('apilog')->info($request, [
            //    'auth' => auth()->user()->name,
            //]);
            $provider = cache()->remember('provider-user-'.auth()->user()->id.'-'.$request->channel, $this->cacheDuration, function() use ($request) {
                return auth()->user()->providerUser->where('channel', strtoupper($request->channel))->first()->provider;
            });

            $request->merge([
                'provider' => $provider
            ]);

            if($provider){
                $retriver = explode(",", $request->to);
                Log::debug('retrive'. $retriver);
                $allretriver = $request->to;
                $balance = (int)balance(auth()->user());
                if($balance>500 && count($retriver)<$balance/1){
                    //CHECK OTP
                    //auto check otp / non otp type base on text
                    if(strpos(strtolower($request->channel), 'sms') !== false){
                        $checkString = $request->text;
                        $otpWord = ['Angka Rahasia', 'Authorisation', 'Authorise', 'Authorization', 'Authorized', 'Code', 'Harap masukkan', 'Kata Sandi', 'Kode',' Kode aktivasi', 'konfirmasi', 'otentikasi', 'Otorisasi', 'Rahasia', 'Sandi', 'trx', 'unik', 'Venfikasi', 'KodeOTP', 'NewOtp', 'One-Time Password', 'Otorisasi', 'OTP', 'Pass', 'Passcode', 'PassKey', 'Password', 'PIN', 'verifikasi', 'insert current code', 'Security', 'This code is valid', 'Token', 'Passcode', 'Valid OTP', 'verification','Verification', 'login code', 'registration code', 'secunty code'];
                        if($request->otp){
                            $request->merge([
                                'otp' => 1
                            ]);
                        }elseif(Str::contains($checkString, $otpWord)){
                            $request->merge([
                                'otp' => 1
                            ]);
                        }else{
                            $request->merge([
                                'otp' => 0
                            ]);
                        }
                    }
                    //GET CREDENTIAL MK
                    if(strtolower($request->channel)=='wa'){
                        $credential = null;
                        foreach(auth()->user()->credential as $cre){
                            if($cre->client=='api_wa_mk'){
                                $credential = $cre;
                            }
                        }
                    }
                    //ADD CAMPAIGN API
                    $campaign = $this->campaignAdd($request);
                    //THIS WILL QUEUE SMS JOB
                    //COUNT PHONE NUMBER REQUESTED
                    //GROUP RETRIVER

                    $phones = $retriver;
                    if(count($phones)>1){

                        Log::info('masuk sini kalau phone >1');
                        //GROUP RETRIVER
                        foreach($phones as $p){
                            $data = array(
                                'type' => $request->type,
                                'to' => trim($p),
                                'from' => $request->from,
                                'text' => $request->text,
                                'servid' => $request->servid,
                                'title' => $request->title,
                                'otp' => $request->otp,
                                'provider' => $provider,
                            );
                            if($request->has('templateid')){
                                $data['templateid'] = $request->templateid;
                            }
                            if(strtolower($request->channel)=='email'){
                                //THIS WILL QUEUE EMAIL JOB
                                //return $data;
                                $reqArr = json_encode($request->all());
                                ProcessEmailApi::dispatch($data, auth()->user(), $reqArr);
                            }elseif(strpos(strtolower($request->channel), 'sms') !== false){
                                ProcessSmsApi::dispatch($data, auth()->user());
                            }elseif(strtolower($request->channel)=='wa'){
                                if($credential){
                                    ProcessWaApi::dispatch($data, $credential);
                                }else{
                                    return response()->json([
                                        'code'          => 401,
                                        'campaign_id'   => $campaign->uuid,
                                        'message'       => "Campaign successful create, but invalid credential",
                                    ]);
                                }
                            }elseif(strtolower($request->channel)=='long_wa'){
                                $request->merge([
                                    'provider' => $provider
                                ]);
                                ProcessWaApi::dispatch($request->all(), auth()->user());
                            }elseif(strtolower($request->channel)=='long_sms'){
                                $request->merge([
                                    'provider' => $provider
                                ]);
                                ProcessSmsApi::dispatch($request->all(), auth()->user());
                            }
                        }
                    }else{
                        //SINGLE RETRIVER
                        if(strtolower($request->channel)=='email'){
                            $reqArr = json_encode($request->all());
                            //THIS WILL QUEUE EMAIL JOB
                            ProcessEmailApi::dispatch($request->all(), auth()->user(), $reqArr, $campaign);
                        }elseif(strpos(strtolower($request->channel), 'sms') !== false){
                            //THIS WILL QUEUE SMS JOB
                            ProcessSmsApi::dispatch($request->all(), auth()->user(), $campaign);
                        }elseif(strtolower($request->channel)=='wa'){
                            if($credential){
                                //THIS WILL QUEUE WA JOB
                                ProcessWaApi::dispatch($request->all(), $credential,$campaign);
                            }else{
                                return response()->json([
                                    'code'          => 401,
                                    'campaign_id'   => $campaign->uuid,
                                    'message'       => "Campaign successful create, but invalid provider credential!"
                                ]);
                            }
                        }elseif($request->channel=='long_wa'){
                            $request->merge([
                                'provider' => $provider
                            ]);
                            //THIS WILL QUEUE WALN JOB
                            ProcessWaApi::dispatch($request->all(), auth()->user(), $campaign);
                        }elseif(strtolower($request->channel)=='long_sms'){
                            $request->merge([
                                'provider' => $provider
                            ]);
                            //THIS WILL QUEUE SMSLN JOB
                            ProcessSmsApi::dispatch($request->all(), auth()->user(), $campaign);
                        }
                    }

                    // show result on progress
                    return response()->json([
                        'code'          => 200,
                        'campaign_id'   => $campaign->uuid,
                        'message'       => "Campaign successful create, prepare sending notification to ".count($phones)." contact.",
                    ]);
                }else{
                    return response()->json([
                        'code'      => 405,
                        'message'   => "Campaign fail to created, Insufficient Balance!",
                    ]);
                }
            }else{
                return response()->json([
                    'code'      => 405,
                    'message'   => "Campaign fail to created, please check your provider or ask Administrator!"
                ]);
            }
            //$this->sendSMS($request->all());
        }catch(\Exception $e){
            return response()->json([
                'code'      => 400,
                'message'   => $e->getMessage()
            ]);
        }
    }

    /**
     * This to add campaign default create by API
     *
     * @param  mixed $request
     * @return object $campaign
     */
    private function campaignAdd($request, $audience_id=null){
        return Campaign::create([
            'title'         => $request->title,
            'channel'       => strtoupper($request->channel),
            'provider'      => $request->provider->code,
            'from'          => $request->from,
            'to'            => $audience_id ? 'Audience:'.$audience_id : $request->to,
            'audience_id'   => $audience_id,
            'text'          => $request->text,
            'is_otp'        => $request->otp ?? '',
            'request_type'  => 'api',
            'status'        => 'starting',
            'way_type'      => 1,
            'type'          => $request->type,
            'template_id'   => $request->templateid,
            'user_id'       => auth()->user()->id,
            'uuid'          => Str::uuid()
        ]);
    }


    /**
     * This for sending sendBulk message using file contact
     *
     * @param  mixed $request
     * @return void
     */
    public function sendBulk(Request $request)
    {
        $validateArr = [
            'channel'   => 'required',
            'type'      => 'required|numeric',
            'title'     => 'required|string',
            'text'      => 'required|string',
            'from'      => 'required|string',
            'provider'  => 'required|string',
            'contact'   => 'required|file',
        ];

        if (strpos(strtolower($request->channel), 'sms') !== false) {
            $validateArr['from'] = 'alpha_num|required_if:channel,sms_otp_sid|required_if:channel,sms_notp_sid';
        } elseif (strpos(strtolower($request->channel), 'email') !== false) {
            $validateArr['from'] = 'required';
        }

        $request->validate($validateArr);

        try {
            $provider = cache()->remember('provider-user-' . auth()->user()->id . '-' . $request->channel, $this->cacheDuration, function() use ($request) {
                return auth()->user()->providerUser->where('channel', strtoupper($request->channel))->first()->provider;
            });

            $request->merge(['provider' => $provider]);

            if ($provider) {

                $audience = $this->importContact($request);
                $audience_id = $audience['audience_id'];
                $retriver = array_column($audience['data'], 0);

                $filteredContact = array_filter($retriver, function($phones) {
                    return !empty($phones);
                });

                $allPhones = [];
                foreach ($filteredContact as $phones) {
                    $phonesArray = explode(',', $phones);
                    $allPhones = array_merge($allPhones, $phonesArray);
                }

                if (empty($retriver)) {
                    return response()->json([
                        'code'      => 406,
                        'message'   => "No valid phone numbers found in the imported contacts."
                    ]);
                }

                // check balance minimum for 3K contact or 1,5 juta
                $balance = (int) balance(auth()->user());
                if ($balance > 150000 && count($retriver) < $balance / 1) {
                    // Auto check OTP
                    //Log::info('Auto check OTP');
                    if (strpos(strtolower($request->channel), 'sms') !== false) {
                        $otpWord = ['Angka Rahasia', 'Authorisation', 'Authorise', 'Authorization', 'Authorized', 'Code', 'Harap masukkan', 'Kata Sandi', 'Kode', 'Kode aktivasi', 'konfirmasi', 'otentikasi', 'Otorisasi', 'Rahasia', 'Sandi', 'trx', 'unik', 'Venfikasi', 'KodeOTP', 'NewOtp', 'One-Time Password', 'Otorisasi', 'OTP', 'Pass', 'Passcode', 'PassKey', 'Password', 'PIN', 'verifikasi', 'insert current code', 'Security', 'This code is valid', 'Token', 'Passcode', 'Valid OTP', 'verification', 'Verification', 'login code', 'registration code', 'security code'];
                        if ($request->otp) {
                            $request->merge(['otp' => 1]);
                        } elseif (Str::contains($request->text, $otpWord)) {
                            $request->merge(['otp' => 1]);
                        } else {
                            $request->merge(['otp' => 0]);
                        }
                    }

                    // Get credential for WhatsApp
                    $credential = null;
                    if (strtolower($request->channel) == 'wa') {
                        $credential = auth()->user()->credential->firstWhere('client', 'api_wa_mk');
                    }

                    // Add campaign API
                    $campaign = $this->campaignAdd($request,$audience_id);

                    // Process sending messages
                    $phones = $allPhones;

                    if (count($phones) > env('MIN_CAMPAIGN_CONTACT', 3000)) {

                        if($provider->code=='provider3'){
                            ProcessCampaignApi::dispatch($request->except('contact'), auth()->user(),$campaign);
                        }else{
                        foreach ($phones as $p) {
                            //Log::info('Processing phone: ' . $p);
                            $data = [
                                'type' => $request->type,
                                'to' => trim($p),
                                'from' => $request->from,
                                'text' => $request->text,
                                'servid' => $request->servid,
                                'title' => $request->title,
                                'otp' => $request->otp,
                                'provider' => $provider,
                            ];

                            if ($request->has('templateid')) {
                                $data['templateid'] = $request->templateid;
                            }

                            if (strtolower($request->channel) == 'email') {
                                $reqArr = json_encode($request->all());
                                ProcessEmailApi::dispatch($data, auth()->user(), $reqArr);
                            } elseif (strpos(strtolower($request->channel), 'sms') !== false) {
                                ProcessSmsApi::dispatch($data, auth()->user());
                            } elseif (strtolower($request->channel) == 'wa') {
                                if ($credential) {
                                    ProcessWaApi::dispatch($data, $credential);
                                } else {
                                    return response()->json([
                                        'code'          => 401,
                                        'campaign_id'   => $campaign->uuid,
                                        'message'       => "Campaign successful create, but invalid credential",
                                    ]);
                                }
                            } elseif (strtolower($request->channel) == 'long_wa') {
                                ProcessWaApi::dispatch($request->all(), auth()->user());
                            } elseif (strtolower($request->channel) == 'long_sms') {
                                ProcessSmsApi::dispatch($request->all(), auth()->user());
                            }
                        }}
                    } else {
                        return response()->json([
                            'code'      => 406,
                            'message'   => "Minimum contact 3000 to sending bulk message"
                        ]);
                    }

                    return response()->json([
                        'code'          => 200,
                        'campaign_id'   => $campaign->uuid,
                        'message'       => "Campaign successful create, prepare sending notification to " . count($phones) . " contact.",
                    ]);
                } else {
                    return response()->json([
                        'code'      => 405,
                        'message'   => "Campaign fail to created, Insufficient Balance!",
                    ]);
                }
            } else {
                return response()->json([
                    'code'      => 405,
                    'message'   => "Campaign fail to created, please check your provider or ask Administrator!"
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'code'      => 400,
                'message'   => $e->getMessage()
            ]);
        }
    }

    private function importContact($input)
    {
        $data = [];

        if ($input->contact) {
            $filePath = $input->contact->getRealPath();
            $mimeType = $input->contact->getClientMimeType();

            if ($mimeType == 'text/csv') {
                $fileContents = file($filePath);
                foreach ($fileContents as $key => $line) {
                    if ($key > 0) {
                        $data[] = str_getcsv($line);
                    }
                }
            } else {
                $rows = Excel::toArray([], $filePath)[0];
                foreach ($rows as $key => $row) {
                    if ($key > 0) {
                        $data[] = $row;
                    }
                }
            }

            if (empty($input->audience_id)) {
                $input->audience = Audience::create([
                    'name'        => $input->title,
                    'description' => 'This Audience Created Automatically from Campaign',
                    'user_id'     => auth()->user()->id,
                ]);
            }

            $audience_id = $input->audience->id;
            importAudienceContact::dispatch($data, $audience_id, auth()->user()->id);
        }

            return [
                'data' => $data,
                'audience_id' => $audience_id
            ];
    }


    // ===========================================
    // Function below to testing in Controller
    // ===========================================

    /**
     * saveResult
     *
     * @param  mixed $msg
     * @param  mixed $request
     * @return void
     */
    private function saveResult($msg, $request)
    {
        $user_id = auth()->user()->id;
        $modelData = [
            'msg_id'    => 0,
            'user_id'   => $user_id,
            'client_id' => $this->chechClient("400", null, $request),
            'type'      => $request['type'],
            'status'    => $msg,
            'code'      => "400",
            'message_content'  => $request['text'],
            'price'     => 0,
            'balance'   => 0,
            'msisdn'    => 0,
        ];
        BlastMessage::create($modelData);
    }

    /**
     * chechClient
     *
     * @param  mixed $status
     * @param  mixed $msisdn
     * @param  mixed $request
     * @return void
     */
    private function chechClient($status, $msisdn=null, $request=null)
    {
        $user_id = auth()->user()->id;
        if($status=="200"){
            $client = Client::where('phone', $msisdn)->where('user_id', $user_id)->firstOr(function () use ($msisdn, $user_id) {
                return Client::create([
                    'phone' => $msisdn,
                    'user_id' => $user_id,
                    'uuid' => Str::uuid()
                ]);
            });
        }else{
            $phones = explode (",", $request['to']);
            $client = Client::where('phone', $phones[0])->where('user_id', $user_id)->firstOr(function () use ($phones, $user_id) {
                return Client::create([
                    'phone' => $phones[0],
                    'user_id' => $user_id,
                    'uuid' => Str::uuid()
                ]);
            });
        }

        return $client->uuid;
    }
}
