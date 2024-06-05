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

class ProcessWaApi implements ShouldQueue
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
        $this->request = $request;
        $this->user = $user;
    }

    /**
     * Execute the job to processing WA.
     *
     * @return void
     */
    public function handle()
    {
        //Log::debug($this->service);
        //filter OTP & Non OTP
        if($this->request['provider']=='provider1' || $this->request['otp']){
            $this->MKProvider($this->request);
        }elseif($this->request['provider']=='provider2'){
            $this->EMProvider($this->request);
        }
    }

    /**
     * This function is execute the job using MK Provider
     *
     * @param  mixed $request
     * @return void
     */
    private function MKProvider($request){
        $msg    = '';
        try{
            //$url = 'http://www.etracker.cc/bulksms/mesapi.aspx';
            $url = 'https://www.etracker.cc/OTT/api/Send';
            $sid    = $this->user->api_key;//"AC6c598c40bbbb22a9c3cb76fd7baa67b8";
            $token  = $this->user->server_key;//"500107131bbdb25dee1992053e93409f";
            $send_to =  $this->request['to']; //"6281339668556"

            $username = $this->user->credential;
            $password = $this->user->api_key;

            if($this->request['type']==1){
                if($this->request['text'] && !$this->request['templateid']){
                    $str = $this->request->reply;
                    $pattern = "/(http)/i";
                    $status_url = false;
                    if(preg_match($pattern, $str)){
                        $status_url = true;
                    }
                    $response = Http::withBasicAuth($this->service->credential, $password)->accept('application/xml')->post($url, [
                        'channel' => 'whatsapp',
                        'from' =>  $this->service->server_key,
                        'recipient' => $this->request->client->phone,
                        'type' => 'text',
                        'text' => [
                            "body" => $this->request->reply
                        ],
                        'preview_url' => $status_url
                    ]);
                }else{
                    $response = Http::withBasicAuth($username, $password)->accept('application/xml')->post($url, [
                        'channel' => 'whatsapp',
                        'from' =>  $this->service->user->name,
                        'recipient' => $this->request->client->phone,
                        'type' => 'template',
                        "template"=> [
                            "name"=> "welcome",
                            "ttl"=> 3,
                            "language_code"=> "EN",
                            "template_params"=> [
                                [
                                    "value"=> $this->request->client->name
                                ],
                            ]
                        ]
                    ]);
                }
            }else{
                if($this->request['templateid']){
                    $str = $this->request['text'];
                    $pattern = "/(http)/i";
                    $status_url = false;
                    if(preg_match($pattern, $str)){
                        $status_url = true;
                    }
                    $response = Http::withBasicAuth($username, $password)->accept('application/xml')->post($url, [
                        'channel' => 'whatsapp',
                        'from' => 'Macrokiosk2', //$this->service->server_key,
                        'recipient' => $send_to,
                        'type' => 'template',
                        'template'=> [
                            'name'=> 'reminder',
                            'language_code'=> 'EN',
                            'template_params'=> [
                                [
                                    'value'=> 'David'
                                ],
                                [
                                    'value'=> 'TN12399512'
                                ],
                                [
                                    'value'=>'2020-06-28'
                                ]
                            ]
                        ]
                    ]);
                }elseif($this->request->type=='text'){
                    $str = $this->request->reply;
                    $pattern = "/(http)/i";
                    $status_url = false;
                    if(preg_match($pattern, $str)){
                        $status_url = true;
                    }
                    $response = Http::withBasicAuth($this->service->credential, $password)->accept('application/xml')->post($url, [
                        'channel' => 'whatsapp',
                        'from' =>  $this->service->server_key,
                        'recipient' => $this->request->client->phone,
                        'type' => 'text',
                        'text' => [
                            "body" => $this->request->reply
                        ],
                        'preview_url' => $status_url
                    ]);
                }elseif($this->request->type=='image'){
                    $response = Http::withBasicAuth($this->service->credential, $password)->accept('application/xml')->post($url, [
                        'channel' => 'whatsapp',
                        'from' =>  $this->service->server_key,
                        'recipient' => $this->request->client->phone,
                        'type' => 'image',
                        'image' => [
                            "link" => $this->request->media,
                            "caption" => $this->request->reply
                        ]
                    ]);
                }elseif($this->request->type=='audio'){
                    $response = Http::withBasicAuth($this->service->credential, $password)->accept('application/xml')->post($url, [
                        'channel' => 'whatsapp',
                        'from' =>  $this->service->server_key,
                        'recipient' => $this->request->client->phone,
                        'type' => 'audio',
                        'audio' => [
                            "link" => $this->request->media
                        ]
                    ]);
                }elseif($this->request->type=='video'){
                    $response = Http::withBasicAuth($this->service->credential, $password)->accept('application/xml')->post($url, [
                        'channel' => 'whatsapp',
                        'from' =>  $this->service->server_key,
                        'recipient' => $this->request->client->phone,
                        'type' => 'video',
                        'video' => [
                            "link" => $this->request->media,
                            "caption" => $this->request->reply
                        ]
                    ]);
                }elseif($this->request->type=='document'){
                    $response = Http::withBasicAuth($this->service->credential, $password)->accept('application/xml')->post($url, [
                        'channel' => 'whatsapp',
                        'from' =>  $this->service->server_key,
                        'recipient' => $this->request->client->phone,
                        'type' => 'document',
                        'document' => [
                            "link" => $this->request->media,
                            "filename" => preg_replace('/[^A-Za-z0-9-]+/', '-', $this->request->reply)
                        ]
                    ]);
                }
                else{

                }
            }

            Log::debug($response);

            /*if($response){
                $response  = json_decode(json_encode(simplexml_load_string($response->getBody()->getContents())), true);

                $chat = BlastMessage::find($this->request->id);
                $chat->source_id = @$response['message_id'];
                $chat->save();
            }*/

            // check response code
            if ($response['message_id']){
                $modelData = [
                    'msg_id'    => $response['message_id'],
                    'user_id'   => $this->user->user_id,
                    'client_id' => $this->chechClient("200", $send_to),
                    'sender_id' => '',
                    'type'      => $this->request['text'],
                    'otp'       => 0,
                    'status'    => "PROCESSED",
                    'code'      => '200',
                    'message_content'  => $this->request['text'],
                    'currency'  => 'IDR',
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

            Log::debug("Respone MSG:");
            Log::debug($msg);
            if($msg!=''){
                $this->saveResult($msg);
            }
        }
        catch(\Exception $e){
            Log::debug($e->getMessage());
            $this->saveResult('Reject invalid servid');
            Log::debug('Reject invalid servid');
        }
    }

    /**
     * This function is execure the job EM Provider
     *
     * @param  mixed $request
     * @return void
     */
    private function EMProvider($request){
        try{
            $url = 'https://enjoymov.co/prod-api/kstbCore/sms/send';
            $md5_key = env('EM_MD5_KEY', 'AFD4274C39AB55D8C8D08FA6E145D535'); //'AFD4274C39AB55D8C8D08FA6E145D535';
            $merchantId = env('EM_MERCHANT_ID', 'KSTB904790'); //'KSTB904790';
            $callbackUrl = 'http://hireach.firmapps.ai/receive-sms-status';
            //$phone = '81339668556';
            $content = $request['text']; //'test enjoymov api';
            $msgChannel = env('EM_CODE_LWA', 80); //'WA'; //WA
            //$countryCode = '62';


            $code = str_split($request['to'], 2);
            $countryCode = $code[0];
            $phone = substr($request['to'], 2);

            $sb = $md5_key . $merchantId . $phone . $content;
            //$sign = md5($sb);
            //return $sign;
            $signature = Http::acceptJson()->withUrlParameters([
                'endpoint' => 'http://8.215.55.87:34080/sign',
                'sb' => $sb
            ])->get('{+endpoint}?sb={sb}'); 
            $reSign = json_decode($signature, true);
            //return $signature['sign'];
            //Log::debug($sb);
            //Log::debug($reSign['sign']);
            $sign = $reSign['sign'];

            $msg = $this->saveResult('progress');
            $data = [
                'merchantId' => $merchantId,
                'sign' => $sign,
                'type' => $request['otp']==1?2:1,
                'phone' => $phone,
                'content' => $request['text'],
                "callbackUrl" => $callbackUrl,
                'countryCode' => $countryCode,
                'msgChannel' => $msgChannel,
                "msgId" => $msg->id
            ];
            
            //Log::debug($data);
            $response = Http::withBody(json_encode($data), 'application/json')->withOptions([ 'verify' => false, ])->post($url);
            //Log::debug($response);
            $resData = json_decode($response, true);
            BlastMessage::find($msg->id)->update(['status'=>$resData['message']]);
        }catch(\Exception $e){
            Log::debug($e->getMessage());
            $this->saveResult('Reject invalid servid', $this->request['to']);
            Log::debug('Reject invalid servid');
        }
    }

    /**
     * saveResult
     *
     * @param  mixed $msg
     * @return object $mms
     */
    private function saveResult($msg){
        $user_id = $this->user->id;
        $modelData = [
            'msg_id'            => 0,
            'user_id'           => $user_id,
            'client_id'         => $this->chechClient("400", $this->request['to']),
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

    /**
     * chechClient
     *
     * @param  mixed $status
     * @param  mixed $msisdn
     * @return string uuid
     */
    private function chechClient($status, $msisdn=null){
        $user_id = $this->user->id;
        $client = Client::where('phone', $msisdn)->where('user_id', $user_id)->firstOr(function () use ($msisdn, $user_id) {
            return Client::create([
                'phone' => $msisdn,
                'user_id' => $user_id,
                'uuid' => Str::uuid()
            ]);
        });
        $team = $this->user->currentTeam;
        $client->teams()->attach($team);

        return $client->uuid;
    }
}
