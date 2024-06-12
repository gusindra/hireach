<?php

namespace App\Http\Controllers;

use App\Http\Resources\SmsResource;
use App\Http\Resources\TwoWayResource;
use App\Models\BlastMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Jobs\ProcessChatApi;
use App\Models\ApiCredential;
use App\Models\Client;
use App\Models\ProviderUser;
use App\Models\Request as ModelsRequest;
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
        $customer = Client::where('phone', $request->phone)->first(); //->where('user_id', auth()->user()->id)
        if($customer){
            //$data = ModelsRequest::paginate($request->page);
            $data = ModelsRequest::where('client_id', $customer->uuid)->skip($skip)->take($request->pageSize)->where('user_id', '=', auth()->user()->id)->get();
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
        return response()->json([
            'code' => 200,
            'message' => "Successful",
            'response' => TwoWayResource::collection($data),
        ]);
    }

    /**
     * show record sms by phone number
     *
     * @param  mixed $phone
     * @return void
     */
    public function show($phone)
    {
        $customer = Client::where('phone', $phone)->where('user_id', auth()->user()->id)->first();
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
            'message' => "User not found"
        ]);
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
        //return response()->json([
        //    'message' => "Successful",
        //     'code' => 200
        //]);
        //return $request;
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
                }
                //return $credential;

                if($credential==''){
                    return response()->json([
                        'message' => 'Invalid Credential',
                        'code' => 400
                    ]);
                }

                //auto check otp / non otp type base on text
                $checkString = $request->text;
                $otpWord = ['Angka Rahasia', 'Authorisation', 'Authorise', 'Authorization', 'Authorized', 'Code', 'Harap masukkan', 'Kata Sandi', 'Kode',' Kode aktivasi', 'konfirmasi', 'otentikasi', 'Otorisasi', 'Rahasia', 'Sandi', 'trx', 'unik', 'Venfikasi', 'KodeOTP', 'NewOtp', 'One-Time Password', 'Otorisasi', 'OTP', 'Pass', 'Passcode', 'PassKey', 'Password', 'PIN', 'verifikasi', 'insert current code', 'Security', 'This code is valid', 'Token', 'Passcode', 'Valid OTP', 'verification','Verification', 'login code', 'registration code', 'secunty code'];

                $allphone = $request->to;
                $phones = explode(",", $request->to);
                $balance = (int)balance(auth()->user());
                if($balance>500 && count($phones)<$balance/1){
                    $data = array(
                        'type' => $request->type,
                        'to' => $request->to,
                        'from' => $request->from,
                        'text' => $request->text,
                        'title' => $request->title,
                    );
                    $chat = $this->saveResult(null, $data);
                    ProcessChatApi::dispatch($request->all(), $credential, $chat);
                }else{
                    return response()->json([
                        'message' => "Insufficient Balance",
                        'code' => 405
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
        return response()->json([
            'message' => "Successful, prepare sending to ".count($phones)." msisdn",
            'code' => 200,
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

    private function sendSMS($request){

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

    private function saveResult($msg, $request){
        $user_id = auth()->user()->id;
        //ModelsRequest::create($modelData);
        $client = $this->chechClient("400", $request);
        $chat = ModelsRequest::create([
            'source_id' => 'api_'.Hashids::encode($client->id),
            'reply'     => $request['text'],
            'from'      => $client->id,
            'user_id'   => $user_id,
            'type'      => 'text',
            'client_id' => $client->uuid,
            'sent_at'   => date('Y-m-d H:i:s'),
            'team_id'   => auth()->user()->team->id
        ]);
        return $chat;
    }

    private function chechClient($status, $request=null){
        $user_id = auth()->user()->id;
        $client = Client::where('phone', $request['to'])->where('user_id', $user_id)->firstOr(function () use ($request, $user_id) {
            return Client::create([
                'phone' => $request['to'],
                'user_id' => $user_id,
                'uuid' => Str::uuid()
            ]);
        });
        return $client;
    }
}
