<?php

namespace App\Jobs;

use App\Actions\CheckApiResponse;
use App\Models\BlastMessage;
use App\Models\CampaignModel;
use App\Models\Client;
use App\Models\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use Vinkla\Hashids\Facades\Hashids;

class ProcessSmsApi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $request;
    public $user;
    public $campaign;

    /**
     * Create a new job instance.
     * __construct
     *
     * @param  mixed $request
     * @param  mixed $user
     * @param  mixed $campaign
     * @return void
     */
    public function __construct($request, $user, $campaign = null)
    {
        $this->request = $request;
        $this->user = $user;
        $this->campaign = $campaign;
    }

    /**
     * Execute the job to processing SMS.
     *
     * @return void
     */
    public function handle()
    {
        // Log::debug($this->request);
        //filter OTP & Non OTP
        $provider = $this->request['provider'];
        $mk = array('provider1','mkxfirmapps');
        if (in_array($provider->code, $mk) || $provider->code == 'provider1') {
            $checkApiResponse = new CheckApiResponse;
            $this->MKProvider($this->request, $provider, $checkApiResponse);
        } elseif ($provider->code == 'provider2') {
            $this->EMProvider($this->request);
        }
    }

    /**
     * MKProvider
     *
     * @param  mixed $request
     * @return void
     */
    private function MKProvider($request, $provider, $checkApiResponse)
    {
        if ($request['otp'] == false) {
            $user   = env('MK_NON_OTP_USER');
            $pass   = env('MK_NON_OTP_PSW');
            $serve  = env('MK_NON_OTP_SERVICE');
        } else {
            $user   = env('MK_OTP_USER');
            $pass   = env('MK_OTP_PSW');
            $serve  = env('MK_OTP_SERVICE');
        }
        $setPro = $provider->settingProvider;
        foreach( $setPro  as $env){
            if($env->key=='user_id') $user = $env->value;
            if($env->key=='api_pass') $pass = $env->value;
            if($env->key=='serv_id') $serve = $env->value;
        }
        Log::debug($setPro);

        $msg    = '';
        if (array_key_exists('servid', $request)) {
            $serve  = $request['servid'];
        }
        try {
            $url = env('MK_SMS_URL');
            $response = '';
            if ($request['type'] == "0") {
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

                if (App::environment(['local', 'testing'])) {
                    $response = Http::get(url('http://hireach.test/api/dummy-string'));
                } elseif (App::environment('development')) {
                    $response = Http::get('https://hireach.archeeshop.com/api/dummy-string');
                } else {
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
                        'provider' => $this->request['provider']->id
                    ]);
                }
            }
            // check response code
            if (strlen($response)<5) {
                $msg = $checkApiResponse->macrokiosk($response);
            } else {
                // if (isJSON($response)) {
                //     // JSON is valid
                //     $array_res = json_decode(json_encode(simplexml_load_string($response->getBody()->getContents())), true);
                //     //Log::debug($array_res);
                // }else{
                // }

                $array_res = [];
                $res = explode("|", $response);
                $balance = 0;
                if (count($res) > 0 && strpos($response, '=') !== false) {
                    foreach ($res as $k1 => $data) {
                        $data_res = explode(",", $data);
                        foreach ($data_res as $k2 => $data) {
                            if (count($res) == $k1 + 1) {
                                $balance = $data;
                            } else {
                                $array_res[$k1][$k2] = $data;
                            }
                        }
                    }
                } else {
                    foreach ($res as $k1 => $data) {
                        $data_res = explode(",", $data);
                        foreach ($data_res as $k2 => $singleData) {
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
                foreach ($array_res as $msg_msis) {
                    //check client && array
                    if (is_array($msg_msis)) {
                        if (array_key_exists("1", $msg_msis) && array_key_exists("0", $msg_msis) && array_key_exists("2", $msg_msis) && array_key_exists("3", $msg_msis) && array_key_exists("4", $msg_msis)) {
                            $client = $this->chechClient("200", $msg_msis[0]);
                            $modelData = [
                                'msg_id'    => preg_replace('/\s+/', '', $msg_msis[1]),
                                'user_id'   => $this->user->id,
                                'client_id' => $client->uuid,
                                'sender_id' => $request['from'],
                                'type'      => $request['type'],
                                'otp'       => $request['otp'],
                                'provider'  => $request['provider']->id,
                                'status'    => "PROCESSED",
                                'code'      => $msg_msis[2],
                                'message_content'  => $request['text'],
                                'currency'  => $msg_msis[3],
                                'price'     => $msg_msis[4],
                                'balance'   => $balance,
                                'msisdn'    => preg_replace('/\s+/', '', $msg_msis[0]),
                            ];
                            Log::debug($modelData);
                            if ($request['resource'] == 2) {
                                // Log::debug("INI BUKAN EM");
                                $mms = Request::create([
                                    'source_id' => $modelData?$modelData['msg_id']:'smschat_' . Hashids::encode($client->id),
                                    'reply'     => $request['text'],
                                    'from'      => $client->id,
                                    'user_id'   => $this->user->id,
                                    'type'      => 'text',
                                    'client_id' => $client->uuid,
                                    'sent_at'   => date('Y-m-d H:i:s'),
                                    'team_id'   =>  $this->request['team_id'],
                                ]);;
                            } else {
                                $mms = BlastMessage::create($modelData);
                            }
                            $this->synCampaign($mms);
                        } else {
                            Log::debug("failed msis format: ");
                            Log::debug($msg_msis);
                        }
                    }
                }
            }
            Log::debug("Respone MSG:");
            Log::debug($msg);
            if ($msg != '') {
                $this->saveResult($msg);
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            Log::debug('Reject invalid servid');
            $this->saveResult('Reject invalid servid');
        }
        //}else{
        //    $this->saveResult('Reject invalid servid');
        //}
    }

    /**
     * EMProvider
     *
     * @param  mixed $request
     * @return void
     */
    private function EMProvider($request)
    {
        $msg = $this->saveResult('progress');
        if ($msg) {

            if (App::environment(['local', 'testing'])) {
                $msgChannel = 99;
                Log::debug($resData = Http::get(url('http://hireach.test/api/dummy-array')));
                $response = Http::get(url('http://hireach.test/api/dummy-array'));
            } elseif (App::environment('development')) {
                $msgChannel = 99;
                $response = Http::get('https://hireach.archeeshop.com/api/dummy-array');
            } else {
                $url = 'https://enjoymov.co/prod-api/kstbCore/sms/send';
                $md5_key = env('EM_MD5_KEY', 'A'); //'AFD4274C39AB55D8C8D08FA6E145D535';
                $merchantId = env('EM_MERCHANT_ID', 'A'); //'KSTB904790';
                $callbackUrl = 'http://hireach.firmapps.ai/api/callback-status/blast/' . $msg->id;

                $content = $request['text'];
                $msgChannel = env('EM_CODE_LSMS', 5);

                $code = str_split($request['to'], 2);
                $countryCode = $code[0];
                $phone = substr($request['to'], 2);


                $sb = $md5_key . $merchantId . $phone . $content;
                $signature = Http::acceptJson()->withUrlParameters([
                    'endpoint' => 'http://8.215.55.87:34080/sign',
                    'sb' => $sb
                ])->get('{+endpoint}?sb={sb}');
                $reSign = json_decode($signature, true);
                //return $signature['sign'];
                //Log::debug($sb);
                //Log::debug($reSign['sign']);
                $sign = $reSign['sign'];

                $data = [
                    'merchantId' => $merchantId,
                    'sign' => $sign,
                    'type' => $request['otp'] == 1 ? 2 : 1,
                    'phone' => $phone,
                    'content' => $request['text'],
                    "callbackUrl" => $callbackUrl,
                    'countryCode' => $countryCode,
                    'msgChannel' => $msgChannel,
                    "msgId" => $msg->id
                ];

                $response = Http::withBody(json_encode($data), 'application/json')->withOptions(['verify' => false,])->post($url);
            }

            //Log::debug($data);

            //Log::debug($response);
            $resData = json_decode($response, true);
            if ($request['resource'] == 1) {
                BlastMessage::find($msg->id)->update(['status' => $resData['message'], 'code' => $resData['code'], 'sender_id' => 'SMS_LONG', 'type' => $msgChannel, 'provider' => $provider = $this->request['provider']->id]);
            }
        }
    }

    /**
     * saveResult
     *
     * @param  mixed $msg
     * @return object $mms
     */
    private function saveResult($msg)
    {
        $user_id = $this->user->id;
        $client = $this->chechClient("400");
        $modelData = [
            'msg_id'            => 0,
            'user_id'           => $user_id,
            'client_id'         => $client->uuid,
            'type'              => $this->request['type'],
            'otp'               => $this->request['otp'],
            'status'            => $msg,
            'code'              => "400",
            'message_content'   => $this->request['text'],
            'price'             => 0,
            'balance'           => 0,
            'provider'          => $this->request['provider']->id,
            'msisdn'            => $this->request['to'],
        ];
        if ($this->request['resource'] == 2) {
            Log::debug('masuk sinni');
            $mms = Request::create([
                'source_id' => 'smschat_' . Hashids::encode($client->id),
                'reply'     => $this->request['text'],
                'from'      => $client->id,
                'user_id'   => $user_id,
                'type'      => 'text',
                'client_id' => $client->uuid,
                'sent_at'   => date('Y-m-d H:i:s'),
                'team_id'   =>  $this->request['team_id'],
            ]);;
        } else {
            $mms = BlastMessage::create($modelData);
        }
        $this->synCampaign($mms);
        return $mms;
    }

    /**
     * chechClient
     *
     * @param  mixed $status
     * @param  mixed $msisdn
     * @return object App\Models\Client
     */
    private function chechClient($status, $msisdn = null)
    {
        $user_id = $this->user->id;
        if ($status == "200") {
            $client = Client::where('phone', $msisdn)->where('user_id', $user_id)->firstOr(function () use ($msisdn, $user_id) {
                return Client::create([
                    'phone' => $msisdn,
                    'user_id' => $user_id,
                    'uuid' => Str::uuid()
                ]);
            });
        } else {
            Log::debug('masuk to');
            Log::debug($this->request['to']);
            $phones = explode(",", $this->request['to']);
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

        return $client;
    }

    private function synCampaign($blast)
    {
        if ($blast && !is_null($this->campaign)) {
            CampaignModel::create(['campaign_id' => $this->campaign->id, 'model' => 'BlastMessage', 'model_id' => $blast->id]);
        }
    }
}
