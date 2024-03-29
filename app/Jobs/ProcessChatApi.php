<?php

namespace App\Jobs;

use App\Models\BlastMessage;
use App\Models\Client;
use App\Models\Request as Chat;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProcessChatApi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $request;
    public $data;
    public $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request, $user, $data)
    {
        $this->request = $request;
        $this->user = $user;
        $this->data = $data;
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
        $this->MKProvider($this->request);
        //if($this->request['provider']=='provider1'){
        //}elseif($this->request['provider']=='provider2'){
        //    $this->EMProvider($this->data);
        //}
    }

    private function MKProvider($request){
        $msg    = ''; 
        try{
            $sid    = $this->user->api_key;//"AC6c598c40bbbb22a9c3cb76fd7baa67b8";
            $token  = $this->user->server_key;//"500107131bbdb25dee1992053e93409f";
            $send_to =  $this->request['to']; //"6281339668556"

            // $password = base64_encode($this->user->credential.':'.$this->user->api_key);
            $password = $this->user->api_key;
    
            $url = 'https://www.etracker.cc/OTT/api/Send';
    
            if(@$request['type']==0){
                $response = Http::withBasicAuth($this->user->credential, $password)->accept('application/xml')->post($url, [
                    'channel' => 'whatsapp',
                    'from' =>  $request['from'],
                    'recipient' => $request['to'],
                    'type' => 'template',
                    "template"=> [
                        "name"=> "welcome",
                        "ttl"=> 3,
                        "language_code"=> "EN",
                        "template_params"=> [
                            [
                                "value"=> $request['text'],
                            ],
                        ]
                    ]
                ]);
            }else{
                if($request['type']==1){
                    // TEXT
                    $str = $request['text'];
                    $pattern = "/(http)/i";
                    $status_url = false;
                    if(preg_match($pattern, $str)){
                        $status_url = true;
                    }
                    $form = [
                        'channel' => 'whatsapp',
                        'from' =>   $request['from'],
                        'recipient' =>  $request['to'],
                        'type' => 'text',
                        'text' => [
                            "body" => $request['text']
                        ]
                    ];
                }elseif($request['type']==2){
                    //IMAGE
                    $form = [
                        'channel' => 'whatsapp',
                        'from' =>  $request['from'],
                        'recipient' => $request['to'],
                        'type' => 'image',
                        'image' => [
                            "link" => $request['media'],
                            "caption" => $request['text']
                        ]
                    ];
                }elseif($request['type']==3){
                    //AUDIO
                    $form = [
                        'channel' => 'whatsapp',
                        'from' =>  $request['from'],
                        'recipient' =>  $request['to'],
                        'type' => 'audio',
                        'audio' => [
                            "link" => $request['media']
                        ]
                    ];
                }elseif($request['type']==4){
                    //VIDEO
                    $form = [
                        'channel' => 'whatsapp',
                        'from' =>  $request['from'],
                        'recipient' =>  $request['to'],
                        'type' => 'video',
                        'video' => [
                            "link" => $request['media'],
                            "caption" => $request['text']
                        ]
                    ];
                }elseif($request['type']==5){
                    //DOCUMENT
                    $form = [
                        'channel' => 'whatsapp',
                        'from' =>  $request['from'],
                        'recipient' =>  $request['to'],
                        'type' => 'document',
                        'document' => ["link" => $request['media'],"filename" => preg_replace('/[^A-Za-z0-9-]+/', '-', $request['text'])]
                    ];
                }
                $response = Http::withBasicAuth($this->user->credential, $password)->accept('application/xml')->post($url, $form);
            }
            Log::debug("MK Respone API WA:");
            Log::debug($response);
            if($response){
                $response  = json_decode(json_encode(simplexml_load_string($response->getBody()->getContents())), true);
                $chat = Chat::find($this->data->id);
                if(array_key_exists("message_id",$response)){
                    $chat->source_id = @$response['message_id'];
                }
                if(array_key_exists("MessageID",$response)){
                    $chat->source_id = @$response['MessageID'];
                }
                $chat->save();
                Log::debug($chat->id.' : '.@$response['message_id']);
            }
            // return $response;
            //Log::debug($response);
            // check response code
        }catch(\Exception $e){
            Log::debug($e->getMessage());
            Log::debug('Reject invalid servid');
        }
    }

    private function EMProvider($request){
        $url = 'https://enjoymov.co/prod-api/kstbCore/sms/send';
        $md5_key = env('EM_MD5_KEY'); //'AFD4274C39AB55D8C8D08FA6E145D535';
        $merchantId = env('EM_MERCHANT_ID'); //'KSTB904790';
        $callbackUrl = 'http://hireach.archeeshop.com/receive-sms-status';
        $phone = '81339668556';
        $content = 'test enjoymov api';
        $msgChannel = 'WA';
        $countryCode = '62';
 
        $code = str_split($request->to, 2);
        $countryCode = $code[0];
        $phone = substr($request->to, 2);

        $sb = $md5_key . $merchantId . $phone . $content;
        $sign = md5($sb);
        //return $sign;
        Http::withOptions([ 'verify' => false, ])->post($url, [
            'merchantId' => $merchantId,
            'sign' => $sign,
            'type' => $request->type,
            'phone' => $phone,
            'content' => $request->text,
            "callbackUrl" => $callbackUrl,
            'countryCode' => $countryCode,
            'msgChannel' => $msgChannel,
            "msgId" => $msg->id
        ]);
        
        //$msg = $this->saveResult('progress'); 
    }

    private function saveResult($msg){
        $user_id = $this->user->id;
        $request = Chat::create([
            'source_id' => Hashids::encode($this->client->id),
            'reply'     => $this->request['text'],
            'from'      => $this->chechClient("400"),
            'user_id'   => $this->user->id,
            'type'      => 'text',
            'client_id' => $this->client->uuid,
            'sent_at'   => date('Y-m-d H:i:s'),
            'team_id'   => $this->team->id
        ]);
        /*$modelData = [
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
        $mms = Chat::create($modelData);*/
        return $request;
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
