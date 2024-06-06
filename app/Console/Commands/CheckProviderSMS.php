<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CheckProviderSMS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:sms {provider}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to check provider sms status';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $request['to'] = '6281339668556';
        $request['title'] = 'testing sms';
        $request['text'] = 'testing sms';

        if($this->argument('provider')=='enjoymov'){ 
            $url = 'https://enjoymov.co/prod-api/kstbCore/sms/send';
            $md5_key = env('EM_MD5_KEY', 'AFD4274C39AB55D8C8D08FA6E145D535'); //'AFD4274C39AB55D8C8D08FA6E145D535';
            $merchantId = env('EM_MERCHANT_ID', 'KSTB904790'); //'KSTB904790';
            $callbackUrl = 'http://hireach.firmapps.ai/receive-sms-status'; 
            $content = $request['text'];
            $msgChannel = env('EM_CODE_LSMS', 5);
            $countryCode = '62';

            $code = str_split($request['to'], 2);
            $countryCode = $code[0];
            $phone = substr($request['to'], 2);

            $sb = $md5_key . $merchantId . $phone . $content; 
            $signature = Http::acceptJson()->withUrlParameters([
                'endpoint' => 'http://8.215.55.87:34080/sign',
                'sb' => $sb
            ])->get('{+endpoint}?sb={sb}'); 
            $reSign = json_decode($signature, true); 
            $sign = $reSign['sign'];
            
            $data = [
                'merchantId' => $merchantId,
                'sign' => $sign,
                'type' => 1,
                'phone' => $phone,
                'content' => $request['text'],
                "callbackUrl" => $callbackUrl,
                'countryCode' => $countryCode,
                'msgChannel' => $msgChannel,
                "msgId" => 0
            ]; 
            $response = Http::withBody(json_encode($data), 'application/json')->withOptions([ 'verify' => false, ])->post($url);
            $resData = json_decode($response, true);
            if($resData['message']=='Success'){
                $this->line("SMS is OK");
            }else{
                $this->line("SMS is ERROR");
            }
        }elseif($this->argument('provider')=='macrokiosk'){
            if($request['otp']==false){
                $user   = env('MK_NON_OTP_USER');
                $pass   = env('MK_NON_OTP_PSW');
                $serve  = env('MK_NON_OTP_SERVICE');
            }else{
                $user   = env('MK_OTP_USER');
                $pass   = env('MK_OTP_PSW');
                $serve  = env('MK_OTP_SERVICE');
            }

            if(array_key_exists('servid', $request)){
                $serve  = $request['servid'];
            } 

            $url = 'http://www.etracker.cc/bulksms/mesapi.aspx'; 
            $response = '';
            if($request['type']=="0"){ 
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
            } 
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
                $this->line("SMS is OK");
            }   
        }
    }
}
