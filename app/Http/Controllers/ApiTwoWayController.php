<?php

namespace App\Http\Controllers;

use App\Http\Resources\CampaignResource;
use App\Http\Resources\SmsResource;
use App\Http\Resources\TwoWayResource;
use App\Models\BlastMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Jobs\ProcessChatApi;
use App\Jobs\ProcessInboundMessage;
use App\Models\ApiCredential;
use App\Models\Campaign;
use App\Models\Client;
use App\Models\ProviderUser;
use App\Models\Request as ModelsRequest;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Vinkla\Hashids\Facades\Hashids;

class ApiTwoWayController extends Controller
{
    public $cacheDuration = 1440;

    /**
     * get all record sms
     *
     * @return void
     */
    public function index(Request $request)
    {
        //$data = ModelsRequest::where('user_id', '=', auth()->user()->id)->get();
        $skip = $request->page*$request->pageSize;
        $customer = Client::where('phone', $request->phone)->where('user_id', auth()->user()->id)->first(); //
        if($customer){
            //$data = ModelsRequest::paginate($request->page);
            $data = ModelsRequest::where('client_id', $customer->uuid)->skip($skip)->take($request->pageSize)->where('user_id', '=', $customer->user_id)->get();
            if(count($data)>=1){
                return response()->json([
                    'code' => 200,
                    'message' => "Successful",
                    'page'  => $request->page,
                    'response' => TwoWayResource::collection($data),
                ]);
            }
        }
        return response()->json([
            'code' => 404,
            'message' => "Can not found client from Phone Number"
        ]);
    }

    /**
     * show record sms by phone number
     *
     * @param  mixed $phone
     * @return void
     */
    public function show(Request $request)
    {
        // return response()->json([
        //     'code' => 404,
        //     'message' => "User not found"
        // ]);
        if(is_numeric($request->value)){
            $customer = Client::where('phone', $request->value)->where('user_id', auth()->user()->id)->first();
            if($customer){
                $data = ModelsRequest::where('user_id', '=', auth()->user()->id)->where('client_id', $customer->uuid)->get();

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
                $data = ModelsRequest::where('user_id', '=', auth()->user()->id)->where('client_id', $customer->uuid)->get();

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
     * post new sms
     *
     * @param  mixed $request
     * @return void
     */
    public function post(Request $request)
    {
        //get the request & validate parameters
        $fields = $request->validate([
            'type' => 'required|numeric',
            'to' => 'required|string',
            'from' => 'required|alpha_num',
            'text' => 'required|string',
            'title' => 'required|string',
            'detail' => 'string',
            'otp' => 'boolean'
        ]);

        try{
            $provider = cache()->remember('provider-user-', $this->cacheDuration, function() use ($request) {
                return ProviderUser::where('user_id', auth()->user()->id)->where('channel', $request->channel)->first();
            });

            if($provider){
                //$userCredention = ApiCredential::where("user_id", auth()->user()->id)->where("client", "api_sms_mk")->where("is_enabled", 1)->first();
                //Log::channel('apilog')->info($request, [
                //    'auth' => auth()->user()->name,
                //]);
                // ProcessSmsApi::dispatch($request->all(), auth()->user());
                $credential = '';
                if($request->channel=='wa'){
                    foreach(auth()->user()->credential as $cre){
                        if($cre->client=='api_wa_mk'){
                            $credential = $cre;
                        }
                    }
                    if($credential==''){
                        return response()->json([
                            'message' => 'Invalid Credential',
                            'code' => 400
                        ]);
                    }
                }
                //return $credential;


                //auto check otp / non otp type base on text
                $checkString = $request->text;
                $otpWord = ['Angka Rahasia', 'Authorisation', 'Authorise', 'Authorization', 'Authorized', 'Code', 'Harap masukkan', 'Kata Sandi', 'Kode',' Kode aktivasi', 'konfirmasi', 'otentikasi', 'Otorisasi', 'Rahasia', 'Sandi', 'trx', 'unik', 'Venfikasi', 'KodeOTP', 'NewOtp', 'One-Time Password', 'Otorisasi', 'OTP', 'Pass', 'Passcode', 'PassKey', 'Password', 'PIN', 'verifikasi', 'insert current code', 'Security', 'This code is valid', 'Token', 'Passcode', 'Valid OTP', 'verification','Verification', 'login code', 'registration code', 'secunty code'];

                $allphone = $request->to;
                $phones = explode(",", $request->to);
                $balance = (int)balance(auth()->user());

                //ADD CAMPAIGN API
                $campaign = $this->campaignAdd($request);

                if($balance>500 && count($phones)<$balance/1){
                    if(count($phones)>1){
                        foreach($phones as $p){
                            $data = array(
                                'type' => $request->type,
                                'to' => trim($p),
                                'from' => $request->from,
                                'text' => $request->text,
                                //'servid' => $request->servid,
                                'channel' => $request->channel,
                                'title' => $request->title,
                                'otp' => $request->otp,
                                'is_otp' => $request->otp,
                                'provider' => $provider,
                            );
                            if($request->has('templateid')){
                                $data['templateid'] = $request->templateid;
                            }
                            $chat = $this->saveResult($campaign, $data);
                            if($request->channel!='webchat')
                                ProcessChatApi::dispatch($request->all(), $credential, $chat);
                        }
                    }else{
                        $data = array(
                            'type' => $request->type,
                            'to' => $request->to,
                            'from' => $request->from,
                            'text' => $request->text,
                            'channel' => $request->channel,
                            'is_otp' => $request->otp,
                            'title' => $request->title,
                        );
                        $chat = $this->saveResult($campaign, $data);
                        if($request->channel!='webchat')
                            ProcessChatApi::dispatch($request->all(), $credential, $chat);
                    }

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
                //$this->sendSMS($request->all());
            }else{
                return response()->json([
                    'message' => "Please check your provider or ask Administrator",
                    'code' => 405
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'code' => 400
            ]);
        }
        // show result on progress
        // show result on progress

        // return response()->json([
        //     'message' => "Successful, prepare sending to ".count($phones)." msisdn",
        //     'code' => 200,
        // ]);
    }

    /**
     * This to add campaign default create by API
     *
     * @param  mixed $request
     * @return object $campaign
     */
    private function campaignAdd($request){
        return Campaign::create([
            'title'         => $request->title,
            'channel'       => strtoupper($request->channel),
            'provider'      => $request->provider,
            'from'          => $request->from,
            'to'            => $request->to,
            'text'          => $request->text,
            'is_otp'        => 0,
            'request_type'  => 'api',
            'status'        => 'starting',
            'way_type'      => 2,
            'type'          => $request->type,
            'template_id'   => $request->templateid,
            'user_id'       => auth()->user()->id,
            'uuid'          => Str::uuid()
        ]);
    }

    /**
     * send Bulk sms
     *
     * @param  mixed $request
     * @return void
     */
    public function sendBulk(Request $request)
    {
        Log::channel('apilog')->info($request, [
            'auth' => auth()->user()->name,
        ]);
        $totalPhone = 0;
        try{
            foreach($request->all() as $sms){
                $checkString = $sms->text;
                $otpWord = ['Angka Rahasia', 'Authorisation', 'Authorise', 'Authorization', 'Authorized', 'Code', 'Harap masukkan', 'Kata Sandi', 'Kode',' Kode aktivasi', 'konfirmasi', 'otentikasi', 'Otorisasi', 'Rahasia', 'Sandi', 'trx', 'unik', 'Venfikasi', 'KodeOTP', 'NewOtp', 'One-Time Password', 'Otorisasi', 'OTP', 'Pass', 'Passcode', 'PassKey', 'Password', 'PIN', 'verifikasi', 'insert current code', 'Security', 'This code is valid', 'Token', 'Passcode', 'Valid OTP', 'verification','Verification', 'login code', 'registration code', 'secunty code'];
                if($request->otp == 1){
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

                $phones = explode(",", $sms->to);
                $balance = (int)balance(auth()->user());
                if($balance>500 && count($phones)<$balance/520){
                    if(count($phones)>1){
                        foreach($phones as $p){
                            $data = array(
                                'type' => $sms->type,
                                'to' => trim($p),
                                'from' => $sms->from,
                                'text' => $sms->text,
                                'servid' => $sms->servid,
                                'title' => $sms->title,
                                'otp' => $sms->otp,
                            );
                            // ProcessSmsApi::dispatch($data, auth()->user());
                            $totalPhone += 1;
                        }
                    }else{
                        // ProcessSmsApi::dispatch($sms, auth()->user());
                        $totalPhone += 1;
                    }
                }else{
                    return response()->json([
                        'message' => "Insufficient Balance",
                        'code' => 405
                    ]);
                }
            }
        }catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'code' => 400
            ]);
        }
        // show result on progress
        return response()->json([
            'message' => "Successful, prepare sending ".count($sms)." text to ".$totalPhone." msisdn.",
            'code' => 200
        ]);
    }

    /**
     * saveResult
     *
     * @param  mixed $campaign
     * @param  mixed $request
     * @param  mixed $prev
     * @return void
     */
    private function saveResult($campaign, $request, $prev=null){
        $user_id = auth()->user()->id;
        //ModelsRequest::create($modelData);
        $client = $this->chechClient("400", $request);
        $text = $campaign?'campaign'.$campaign->id:$request['text'];

        $data = [
            'source_id' => 'webchat_api_'.Hashids::encode($client->id),
            'reply'     => $text,
            'from'      => $client->id,
            'user_id'   => $user_id,
            'type'      => 'text',
            'client_id' => $client->uuid,
            'sent_at'   => date('Y-m-d H:i:s'),
            'team_id'   => auth()->user()->team->id
        ];

        $chat = ModelsRequest::create($data);
        return $chat;
    }

    /**
     * chechClient
     *
     * @param  mixed $status
     * @param  mixed $request
     * @return object App\Models\Client
     */
    private function chechClient($status, $request=null){
        $user_id = auth()->user()->id;
        $request['email'] = strpos($request['to'], '@') ? $request['to'] : '';
        $request['phone'] = !strpos($request['to'], '@') ? $request['to'] : '';
        $client = Client::where('phone',  $request['phone'])->where('user_id', $user_id)->firstOr(function () use ($request, $user_id) {
            return Client::create([
                'phone' =>  $request['phone'],
                'email' => $request['email'],
                'user_id' => $user_id,
                'uuid' => Str::uuid()
            ]);
        });
        return $client;
    }

    public function retriveNewMessage(Request $request, $provider){
        $status=0;
        //return $request;
        if($provider=='sms-mk'){
            if($request->msgid){
                $prvMsg = ModelsRequest::where('from', $request->msisdn)->where('source_id', $request->msgid)->first();
                $exsistingMsg = ModelsRequest::where('from', $request->msisdn)->where('source_id', $request->msgid)->where('reply', $request->text)->where('sent_at', Carbon::createFromFormat('Y-m-dH:i:s', $request->time))->first();
                if($exsistingMsg){
                    return response()->json([
                        'code' => 401,
                        'message' => "Duplicate request, this message is exsist"
                    ]);
                }
            }
            if($request->shortcode){
                //MK SHORT CODE MO
                // $this->saveResult(null, $request, $prvMsg);
                ProcessInboundMessage::dispatch($request->all(), $prvMsg);
                $status=1;
            }elseif($request->longcode){
                //MK LONG CODE MO
                // $this->saveResult(null, $request, $prvMsg);
                ProcessInboundMessage::dispatch($request->all(), $prvMsg);
                $status=1;
            }
        }

        if($status){
            return response()->json([
                'code' => 200,
                'message' => "Successful"
            ]);
        }
        return response()->json([
            'code' => 400,
            'message' => "Message fail to store"
        ]);
    }
}
