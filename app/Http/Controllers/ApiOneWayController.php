<?php

namespace App\Http\Controllers;

use App\Http\Resources\OneWayResource;
use App\Http\Resources\SmsResource;
use App\Models\BlastMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Jobs\ProcessSmsApi;
use App\Jobs\ProcessEmailApi;
use App\Jobs\ProcessWaApi;
use App\Models\ApiCredential;
use App\Models\Client;
use App\Models\ProviderUser;
use Illuminate\Support\Str;

class ApiOneWayController extends Controller
{
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
    public function show($phone)
    {
        $customer = Client::where('phone', $phone)->where('user_id', auth()->user()->id)->first();
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
            'message' => "User not found"
        ]);
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
            'otp'       => 'boolean'
        ];
        if(strpos( $request->channel, 'sms' ) !== false){
            $validateArr['from'] = 'alpha_num|required_if:channel,sms_otp_sid|required_if:channel,sms_notp_sid';
        }elseif($request->channel == 'email'){
            $validateArr['from'] = 'required';
        }
        $fields = $request->validate($validateArr);
        try{
            //$userCredention = ApiCredential::where("user_id", auth()->user()->id)->where("client", "api_sms_mk")->where("is_enabled", 1)->first();
            //Log::channel('apilog')->info($request, [
            //    'auth' => auth()->user()->name,
            //]);
            // ProcessSmsApi::dispatch($request->all(), auth()->user());
            //auto check otp / non otp type base on text
            $provider = cache()->remember('provider-user-', $this->cacheDuration, function() use ($request) {
                return ProviderUser::where('user_id', auth()->user()->id)->where('channel', $request->channel)->first();
            });

            if($provider){
                $retriver = explode(",", $request->to);
                $allretriver = $request->to;
                $balance = (int)balance(auth()->user());
                if($balance>500 && count($retriver)<$balance/1){
                    //CHECK OTP
                    if(strpos($request->channel, 'sms') !== false){
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

                    if($request->channel=='wa'){
                        $credential = null;
                        foreach(auth()->user()->credential as $cre){
                            if($cre->client=='api_wa_mk'){
                                $credential = $cre;
                            }
                        }
                    }
                    //THIS WILL QUEUE SMS JOB
                    //COUNT PHONE NUMBER REQUESTED
                    $phones = $retriver;
                    // GROUP RETRIVER

                    if(count($phones)>1){
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
                                'provider' => $request->provider,
                            );
                            if($request->has('templateid')){
                                $data['templateid'] = $request->templateid;
                            }
                            if($request->channel=='email'){
                                //THIS WILL QUEUE EMAIL JOB
                                //return $data;
                                $reqArr = json_encode($request->all());
                                ProcessEmailApi::dispatch($data, auth()->user(), $reqArr);
                            }elseif(strpos($request->channel, 'sms') !== false){
                                ProcessSmsApi::dispatch($data, auth()->user());
                            }elseif($request->channel=='wa'){
                                if($credential){
                                    ProcessWaApi::dispatch($data, $credential);
                                }else{
                                    return response()->json([
                                        'message' => "Invalid credential",
                                        'code' => 401
                                    ]);
                                }
                            }elseif($request->channel=='longwa'){
                                $request->merge([
                                    'provider' => 'provider2'
                                ]);
                                ProcessWaApi::dispatch($request->all(), auth()->user());
                            }elseif($request->channel=='longsms'){
                                $request->merge([
                                    'provider' => 'provider2'
                                ]);
                                ProcessSmsApi::dispatch($request->all(), auth()->user());
                            }
                        }
                    }else{
                        //SINGLE RETRIVER
                        if($request->channel=='email'){
                            $reqArr = json_encode($request->all());
                            //THIS WILL QUEUE EMAIL JOB
                            ProcessEmailApi::dispatch($request->all(), auth()->user(), $reqArr);
                        }elseif(strpos($request->channel, 'sms') !== false){
                            ProcessSmsApi::dispatch($request->all(), auth()->user());
                        }elseif($request->channel=='wa'){
                            if($credential){
                                ProcessWaApi::dispatch($request->all(), $credential);
                            }else{
                                return response()->json([
                                    'message' => "Invalid provider credential",
                                    'code' => 401
                                ]);
                            }
                        }elseif($request->channel=='longwa'){
                            $request->merge([
                                'provider' => 'provider2'
                            ]);
                            ProcessWaApi::dispatch($request->all(), auth()->user());
                        }elseif($request->channel=='longsms'){
                            $request->merge([
                                'provider' => 'provider2'
                            ]);
                            ProcessWaApi::dispatch($request->all(), auth()->user());
                        }
                    }
                }else{
                    return response()->json([
                        'message' => "Insufficient Balance",
                        'code' => 405
                    ]);
                }
            }else{
                return response()->json([
                    'message' => "Please check your provider or ask Administrator",
                    'code' => 405
                ]);
            }
            //$this->sendSMS($request->all());
        }catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'code' => 400
            ]);
        }
        // show result on progress
        return response()->json([
            'message' => "Successful, prepare sending notification to ".count($phones)." contact",
            'code' => 200,
        ]);
    }

    //
    // Function below to testing in Controller
    //
    /**
     * This to send Bulk request
send Bulk sms
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
                            ProcessSmsApi::dispatch($data, auth()->user());
                            $totalPhone += 1;
                        }
                    }else{
                        ProcessSmsApi::dispatch($sms, auth()->user());
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

    private function sendSMS($request)
    {

        $user   = 'TCI01';
        $pass   = 'IFc21bL+';
        $serve  = 'mes01';
        $msg    = "";

        // if(array_key_exists('servid', $request)){
        //     $serve  = $request['servid'];
        // }
        if($serve==$request['servid']){
            // $url = 'http://www.etracker.cc/bulksms/mesapi.aspx';
            $url = 'http://telixcel.com/api/send/smsbulk';

            $response = '';
            if($request['type']=="0"){
                //accept('application/json')->
                $response = Http::get($url, [
                    'user'  => $user,
                    'pass'  => $pass,
                    'type'  => $request['type'],
                    'to'    => $request['to'],
                    'from'  => $request['from'],
                    'text'  => $request['text'],
                    'servid' => $serve,
                    'title' => $request['title'],
                    'detail' => 1,
                ]);
            }

            // check response code
            if($response=='400'){
                $msg = "Missing parameter or invalid field type";
            }elseif($response=='401'){
                $msg = "Invalid username, password or ServID";
            }elseif($response=='402'){
                $msg = "Invalid Account Type (when call using postpaid client’s account)";
            }elseif($response=='403'){
                $msg = "Invalid Email Format";
            }elseif($response=='404'){
                $msg = "Invalid MSISDN Format";
            }elseif($response=='405'){
                $msg = "Invalid Balance Tier Format";
            }elseif($response=='500'){
                $msg = "System Error";
            }else{
                //Log::debug('process array result');
                $array_res = [];
                $res = explode("|", $response);
                $res_end = [];
                //Log::debug('array start');
                foreach($res as $k1 => $data){
                    $data_res = explode (",", $data);
                    foreach($data_res as $k2 => $data){
                        if(count($res)==$k1+1){
                            $res_end[$k2] = $data;
                        }else{
                            $array_res[$k1][$k2] = $data;
                        }
                    }
                }
                // Log::debug($res_end);
                foreach ($array_res as $msg_msis){
                    // Log::debug($this->chechClient("200", $msg_msis[0]));
                    $modelData = [
                        'msg_id'    => $msg_msis[1],
                        'user_id'   => auth()->user()->id,
                        'client_id' => $this->chechClient("200", $msg_msis[0]),
                        'type'      => $request['type'],
                        'status'    => "PROCESSED",
                        'code'      => $msg_msis[2],
                        'message_content'  => $request['text'],
                        'currency'  => $msg_msis[3],
                        'price'     => $msg_msis[4],
                        'balance'   => $res_end[0],
                        'msisdn'    => $msg_msis[0],
                    ];
                    // Log::debug($modelData);
                    BlastMessage::create($modelData);
                }
            }
        }else{
            abort(404, "Serve ID is wrong");
        }

        if($msg!=''){
            $this->saveResult($msg, $request);
        }
    }

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
