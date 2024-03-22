<?php

namespace App\Jobs;

use App\Models\BlastMessage;
use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProcessEmailApi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $request;
    public $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request, $user)
    {
        $request = $request;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //Log::debug($this->service);
        //filter OTP & Non OTP
        // if($this->request['provider']=='provider1' || $this->request['otp']){
        //     $this->MKProvider($this->request);
        // }elseif($this->request['provider']=='provider2'){
        //     $this->EMProvider($this->request);
        // }
        Mail::raw('Text to e-mail', function($message)
        {
            $message->from('saritune@gmail.com', 'Laravel');
            $message->to('gusin44@yahoo.com');
        });
    }

    private function MKProvider($request){
        $msg    = '';
        // if(array_key_exists('servid', $request)){
        //     $serve  = $request['servid'];
        // }
        if($serve==$request['servid']){
            $url = 'http://www.etracker.cc/bulksms/mesapi.aspx';
            //$url = 'http://telixcel.com/api/send/smsbulk';
            //$url = 'http://telixnet.test/api/send/smsbulk';
            $response = '';
            if($request['type']=="0"){
                // $response = Http::asForm()->accept('application/xml')->post($url, [
                //     'user' => $user,
                //     'pass' => $pass,
                //     'type' => $request->type,
                //     'to' => $request->to,
                //     'from' => $request->from,
                //     'text' => $request->text,
                //     'servid' => $request->servid,
                //     'title' => $request->title,
                //     'detail' => 1,
                // ]);
                // accept('application/json')->
                $response = Http::get($url, [
                    'user' => $user,
                    'pass' => $pass,
                    'type' => $request['type'],
                    'to' => $request['to'],
                    'from' => $request['from'],
                    'text' => $request['text'],
                    'servid' => $serve,
                    'title' => $request['title'],
                    'detail' => 1,
                ]);
                // $response = Http::get($url, [
                //     'user' => $user,
                //     'pass' => $pass,
                //     'type' => $request['type'],
                //     'to' => $request['to'],
                //     'from' => $request['from'],
                //     'text' => $request['text'],
                //     'servid' => $serve,
                //     'title' => $request['title'],
                //     'detail' => 1,
                // ]);
            }
            // return $response;
            Log::debug("MK Res:");
            Log::debug($response);
            // check response code
            if($response=='400'){
                $msg = "Missing parameter or invalid field type";
            }elseif($response=='401'){
                $msg = "Invalid username, password or ServID";
            }elseif($response=='402'){
                $msg = "Invalid Account Type (when call using postpaid client’s account)";
            }elseif($response=='403'){
                $msg = "Invalid Account, Your IP address is not allowed";
            }elseif($response=='404'){
                $msg = "Invalid Account, Value for parameter “From” is too long";
            }elseif($response=='405'){
                $msg = "Invalid Parameter, Value for parameter “Type” is not within the options";
            }elseif($response=='406'){
                $msg = "Invalid Parameter, MSISDN given is either too long or too short";
            }elseif($response=='408'){
                $msg = "System Error, Message Queue path retrieval failed";
            }elseif($response=='409'){
                $msg = "System Error, Unable to send message";
            }elseif($response=='411'){
                $msg = "Blacklisted, Recipient has Opted-Out from receive bulk promo message";
            }elseif($response=='412'){
                $msg = "Invalid Account, Account suspended/terminated.";
            }elseif($response=='413'){
                $msg = "Invalid Broadcast Time";
            }elseif($response=='414'){
                $msg = "Invalid Account, nactive Account.";
            }elseif($response=='415'){
                $msg = "Invalid Account, You not subscribe to Bulk SMS service";
            }elseif($response=='416'){
                $msg = "Invalid Account, You not subscribe to this coverage";
            }elseif($response=='417'){
                $msg = "Invalid Account, No route has been configured for this coverage";
            }elseif($response=='418'){
                $msg = "Invalid Account, There is no available route for this broadcast";
            }elseif($response=='419'){
                $msg = "Invalid Account, The Service ID is invalid";
            }elseif($response=='420'){
                $msg = "System Error, System is unable to process the text message";
            }elseif($response=='421'){
                $msg = "System Error, No coverage price has been set for this broadcast";
            }elseif($response=='422'){
                $msg = "Invalid Account, No wallet.";
            }elseif($response=='423'){
                $msg = "Invalid Account, Insufficient credit in wallet.";
            }elseif($response=='424'){
                $msg = "Invalid Account, You not subscribe to this coverage";
            }elseif($response=='425'){
                $msg = "System Error, No setting configuration for this route";
            }elseif($response=='427'){
                $msg = "Invalid Broadcast Title";
            }elseif($response=='500'){
                $msg = "System Error";
            }else{
                // if (isJSON($response)) {
                //     // JSON is valid
                //     $array_res = json_decode(json_encode(simplexml_load_string($response->getBody()->getContents())), true);
                //     //Log::debug($array_res);
                // }else{
                // }

                $array_res = [];
                $res = explode ("|", $response);
                $balance = 0;
                if(count($res)>0 && strpos($response, '=') !== false){
                    foreach($res as $k1 => $data){
                        $data_res = explode (",", $data);
                        foreach($data_res as $k2 => $data){
                            if(count($res)==$k1+1){
                                $balance = $data;
                            }else{
                                $array_res[$k1][$k2] = $data;
                            }
                        }
                    }
                }else{
                    foreach($res as $k1 => $data){
                        $data_res = explode(",", $data);
                        foreach($data_res as $k2 => $singleData){
                            $array_res[$k1][$k2] = $singleData;
                        }
                    }
                }

                //foreach ($array_res as $msg_msis){
                    //check client
                    // if(is_array($msg_msis)){
                    //     $modelData = [
                    //         'msg_id'    => preg_replace('/\s+/', '', $msg_msis[1]),
                    //         'user_id'   => $this->user->id,
                    //         'client_id' => $this->chechClient("200", $msg_msis[0]),
                    //         'sender_id' => $request['from'],
                    //         'type'      => $request['type'],
                    //         'otp'       => $request['otp'],
                    //         'status'    => "PROCESSED",
                    //         'code'      => $msg_msis[2],
                    //         'message_content'  => $request['text'],
                    //         'currency'  => $msg_msis[3],
                    //         'price'     => $msg_msis[4],
                    //         'balance'   => $balance,
                    //         'msisdn'    => preg_replace('/\s+/', '', $msg_msis[0]),
                    //     ];
                    //     // Log::debug($modelData);
                    //     BlastMessage::create($modelData);
                    // }
                foreach ($array_res as $msg_msis){
                    //check client && array
                    if(is_array($msg_msis)){
                        if (array_key_exists("1",$msg_msis) && array_key_exists("0",$msg_msis) && array_key_exists("2",$msg_msis) && array_key_exists("3",$msg_msis) && array_key_exists("4",$msg_msis)){
                            $modelData = [
                                'msg_id'    => preg_replace('/\s+/', '', $msg_msis[1]),
                                'user_id'   => $this->user->id,
                                'client_id' => $this->chechClient("200", $msg_msis[0]),
                                'sender_id' => $request['from'],
                                'type'      => $request['type'],
                                'otp'       => $request['otp'],
                                'status'    => "PROCESSED",
                                'code'      => $msg_msis[2],
                                'message_content'  => $request['text'],
                                'currency'  => $msg_msis[3],
                                'price'     => $msg_msis[4],
                                'balance'   => $balance,
                                'msisdn'    => preg_replace('/\s+/', '', $msg_msis[0]),
                            ];
                            // Log::debug($modelData);
                            BlastMessage::create($modelData);
                        }else{
                            Log::debug("failed msis format: ");
                            Log::debug($msg_msis);
                        }
                    }
                }
            }
            Log::debug("Respone MSG:");
            Log::debug($msg);
            if($msg!=''){
                $this->saveResult($msg);
            }
        }else{
            $this->saveResult('Reject invalid servid');
        }
    }

    private function EMProvider($request){
        $msg = $this->saveResult('progress');
        if($msg){
            $url = 'https://enjoymov.co/prod-api/kstbCore/sms/send';
            $md5_key = env('EM_MD5_KEY'); //'AFD4274C39AB55D8C8D08FA6E145D535';
            $merchantId = env('EM_MERCHANT_ID'); //'KSTB904790';
            $callbackUrl = 'http://hireach.archeeshop.com/receive-sms-status';
            $phone = '81339668556';
            $content = 'test enjoymov api';
            $msgChannel = 'SM'; //WA
            $countryCode = '62';

            
            $code = str_split($request->to, 2);
            $countryCode = $code[0];
            $phone = substr($request->to, 2);
    
            $sb = $md5_key . $merchantId . $phone . $content;
            $sign = md5($sb);
            //return $sign;
            $response = Http::get($url, [
                'merchantId' => $merchantId,
                'sign' => $sign,
                'type' => $request->type,
                'phone' => $phone,
                'content' => $request->text,
                "callbackUrl" => $callbackUrl,
                'countryCode' => $countryCode,
                'msgChannel' => $request['msgChannel'],
                "msgId" => $msg->id
            ]);
        }
    }

    private function saveResult($msg){
        $user_id = $this->user->id;
        $modelData = [
            'msg_id'            => 0,
            'user_id'           => $user_id,
            'client_id'         => $this->chechClient("400"),
            'type'              => $this->request['type'],
            'otp'               => $this->request['otp'],
            'status'            => $msg,
            'code'              => "400",
            'message_content'   => $this->request['text'],
            'price'             => 0,
            'balance'           => 0,
            'msisdn'            => $this->request['to'],
        ];
        $mms = BlastMessage::create($modelData);
        return $mms;
    }

    private function chechClient($status, $msisdn=null){
        $user_id = $this->user->id;
        if($status=="200"){
            $client = Client::where('phone', $msisdn)->where('user_id', $user_id)->firstOr(function () use ($msisdn, $user_id) {
                return Client::create([
                    'phone' => $msisdn,
                    'user_id' => $user_id,
                    'uuid' => Str::uuid()
                ]);
            });
        }else{
            $phones = explode (",", $this->request['to']);
            $client = Client::where('phone', $phones[0])->where('user_id', $user_id)->firstOr(function () use ($phones, $user_id) {
                return Client::create([
                    'phone' => $phones[0],
                    'user_id' => $user_id,
                    'uuid' => Str::uuid()
                ]);
            });
        }
        $team = $this->user->currentTeam;
        $client->teams()->attach($team);

        return $client->uuid;
    }
}
