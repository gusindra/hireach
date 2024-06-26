<?php

namespace App\Jobs;

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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Vinkla\Hashids\Facades\Hashids;

class ProcessWaApi implements ShouldQueue
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
    public function __construct($request, $user,  $campaign = null)
    {
        $this->request = $request;
        $this->user = $user;
        $this->campaign = $campaign;
    }

    /**
     * Execute the job to processing WA.
     *
     * @return void
     */
    public function handle()
    {

        // Log::debug($this->request);
        //filter OTP & Non OTP
        $provider = $this->request['provider'];

        if ($provider->code == 'provider1' || $this->request['otp']) {
            $this->MKProvider($this->request);
        } elseif ($provider->code == 'provider2') {
            $this->EMProvider($this->request);
        } elseif ($provider->code == 'provider3') {
            $this->WTProvider($this->request);
        }
    }

    /**
     * This function is execute the job using MK Provider
     *
     * @param  mixed $request
     * @return void
     */
    private function MKProvider($request)
    {
        $msg    = '';
        try {
            $url = 'http://www.etracker.cc/bulksms/mesapi.aspx';
            $url = 'https://www.etracker.cc/OTT/api/Send';
            $sid    = $this->user->api_key; //"AC6c598c40bbbb22a9c3cb76fd7baa67b8";
            $token  = $this->user->server_key; //"500107131bbdb25dee1992053e93409f";
            $send_to =  $this->request['to']; //"6281339668556"

            $username = $this->user->credential;
            $password = $this->user->api_key;

            if ($this->request['type'] == 1) {
                if ($this->request['text'] && !$this->request['templateid']) {
                    $str = $this->request->reply;
                    $pattern = "/(http)/i";
                    $status_url = false;
                    if (preg_match($pattern, $str)) {
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
                } else {
                    $response = Http::withBasicAuth($username, $password)->accept('application/xml')->post($url, [
                        'channel' => 'whatsapp',
                        'from' =>  $this->service->user->name,
                        'recipient' => $this->request->client->phone,
                        'type' => 'template',
                        "template" => [
                            "name" => "welcome",
                            "ttl" => 3,
                            "language_code" => "EN",
                            "template_params" => [
                                [
                                    "value" => $this->request->client->name
                                ],
                            ]
                        ]
                    ]);
                }
            } else {
                if ($this->request['templateid']) {
                    $str = $this->request['text'];
                    $pattern = "/(http)/i";
                    $status_url = false;
                    if (preg_match($pattern, $str)) {
                        $status_url = true;
                    }
                    $response = Http::withBasicAuth($username, $password)->accept('application/xml')->post($url, [
                        'channel' => 'whatsapp',
                        'from' => 'Macrokiosk2', //$this->service->server_key,
                        'recipient' => $send_to,
                        'type' => 'template',
                        'template' => [
                            'name' => 'reminder',
                            'language_code' => 'EN',
                            'template_params' => [
                                [
                                    'value' => 'David'
                                ],
                                [
                                    'value' => 'TN12399512'
                                ],
                                [
                                    'value' => '2020-06-28'
                                ]
                            ]
                        ]
                    ]);
                } elseif ($this->request->type == 'text') {
                    $str = $this->request->reply;
                    $pattern = "/(http)/i";
                    $status_url = false;
                    if (preg_match($pattern, $str)) {
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
                } elseif ($this->request->type == 'image') {
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
                } elseif ($this->request->type == 'audio') {
                    $response = Http::withBasicAuth($this->service->credential, $password)->accept('application/xml')->post($url, [
                        'channel' => 'whatsapp',
                        'from' =>  $this->service->server_key,
                        'recipient' => $this->request->client->phone,
                        'type' => 'audio',
                        'audio' => [
                            "link" => $this->request->media
                        ]
                    ]);
                } elseif ($this->request->type == 'video') {
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
                } elseif ($this->request->type == 'document') {
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
                } else {
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
            if ($response['message_id']) {
                $client = $this->chechClient("200", $send_to);
                $modelData = [
                    'msg_id'    => $response['message_id'],
                    'user_id'   => $this->user->user_id,
                    'client_id' => $client->uuid,
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
                if ($this->request['resource'] == 2) {
                    $mms = Request::create([
                        'source_id' => 'wachat_' . Hashids::encode($client->id),
                        'reply'     => $this->request['text'],
                        'from'      => $client->id,
                        'user_id'   => $this->user->user_id,
                        'type'      => 'text',
                        'client_id' => $client->uuid,
                        'sent_at'   => date('Y-m-d H:i:s'),
                        'team_id'   => auth()->user()->team->id
                    ]);;
                } else {
                    $mms = BlastMessage::create($modelData);
                }
                $this->synCampaign($mms);
            } else {
                Log::debug("failed msis format: ");
                Log::debug($msg_msis);
            }

            Log::debug("Respone MSG:");
            Log::debug($msg);
            if ($msg != '') {
                $this->saveResult($msg);
            }
        } catch (\Exception $e) {
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
    private function EMProvider($request)
    {
        $msg = $this->saveResult('progress');

        if ($msg) {
            $url = 'https://enjoymov.co/prod-api/kstbCore/sms/send';
            $md5_key = env('EM_MD5_KEY', 'A'); //'AFD4274C39AB55D8C8D08FA6E145D535';
            $merchantId = env('EM_MERCHANT_ID', 'A'); //'KSTB904790';
            $callbackUrl = 'http://hireach.firmapps.ai/api/callback-status/blast/' . $msg->id;

            $content = $request['text'];
            $msgChannel = env('EM_CODE_LWA', 80);

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
                'type' => $request['otp'] == 1 ? 2 : 1,
                'phone' => $phone,
                'content' => $request['text'],
                "callbackUrl" => $callbackUrl,
                'countryCode' => $countryCode,
                'msgChannel' => $msgChannel,
                "msgId" => $msg->id
            ];

            if (App::environment(['local', 'testing'])) {
                $msgChannel = '123TESTING';
                $response = Http::get(url('http://hireach.test/api/dummy-array'));
                $resData = $response->json();
            } elseif (App::environment('development')) {
                $msgChannel = '123DEV';
                $response = Http::get('https://hireach.archeeshop.com/api/dummy-array');
                $resData = $response->json();
            } else {
                $response = Http::withBody(json_encode($data), 'application/json')->withOptions(['verify' => false])->post($url);
                $resData = json_decode($response->body(), true);
            }
            if ($this->request['resource'] == 1) {
                $bm = BlastMessage::find($msg->id)->update(['status' => $resData['message'], 'code' => $resData['code'], 'sender_id' => 'WA_LONG', 'type' => $msgChannel, 'provider' => 4]);
                $this->synCampaign($bm);
            }
        } else {
            $this->saveResult('Reject invalid servid');
        }
    }

    /**
     * This function is execure the job WT Provider
     *
     * @param  mixed $request
     * @return void
     */
    private function WTProvider($request)
    {
        $msg = $this->saveResult('Ready');
        if ($msg) {

            $url = 'https://45.118.134.84:6005/';

            $environment = config('app.env');
            if ($environment === 'local' || $environment === 'testing') {
                Log::debug("THIS LOCAL");
                Log::debug($resData = Http::get(url('http://hireach.test/api/dummy-array')));
                $msgChannel = '123TESTING';
                $response = Http::get(url('http://hireach.test/api/dummy-array'));
                $resData = $response->json();
                Log::debug($resData);
            } else {
                // Production environment: make the actual API call
                // $response = Http::withOptions(['verify' => false,])
                // ->withHeaders([
                //     'Client-Key' => ENV('WTID_CLIENT_KEY', 'MDgxMjM0NTY3Ng=='),
                //     'Client-Secret' => ENV('WTID_CLIENT_SECRET', 'MDgxMjM0NTY3NnwyMDI0LTAxLTMwIDEwOjIyOjIw')])
                // ->attach('campaign_receiver', file_get_contents(storage_path('app\template_contact_wetalk.xlsx')), 'template_contact_wetalk.xlsx')
                // ->post($url . 'api/campaign/create', [
                //     'campaign_name' => 'Testing API from HiReach',
                //     'campaign_text' => 'Hallo testing 1',
                //     // 'campaign_receiver' => new CURLFile(storage_path('app\template_contact_wetalk.xlsx'))
                // ]);
                // $resData = json_decode($response, true);
                // Log::debug($resData);
                // if ($resData['status']) {
                //     // $response = Http::withOptions(['verify' => false,])->withHeaders(['Client-Key' => ENV('WTID_CLIENT_KEY', 'MDgxMjM0NTY3Ng=='), 'Client-Secret' => ENV('WTID_CLIENT_SECRET', 'MDgxMjM0NTY3NnwyMDI0LTAxLTMwIDEwOjIyOjIw')])->patch($url . 'api/campaign/ready/' . $resData['campaign_id']);
                //     Log::debug($response);
                //     $result = json_decode($response, true);
                //     if ($result['status']) {
                //         Log::debug("WA is OK");
                //     } else {
                //         Log::debug("WA is ERROR: " . $result['message']);
                //     }
                // } else {
                //     Log::debug("Campaign WA is FAILED: " . $resData['message']);
                // }
            }
            $resData['message'] = 'Success';
            $resData['code'] = 200;
            if ($this->request['resource'] == 1) {
                $bm = BlastMessage::find($msg->id)->update([
                    'status' => $resData['message'],
                    'code' => $resData['code'],
                    'sender_id' => 'WA_LONG',
                    'type' => 1,
                    'provider' => $this->request['provider']->id
                ]);
                $this->synCampaign($bm);
            }
        } else {
            $this->saveResult('Reject invalid servid');
        }
    }


    /**
     * This to save result of Job Queue
     *
     * @param  mixed $msg
     * @return object $mms
     */
    private function saveResult($msg)
    {
        $user_id = $this->user->is_enabled ? $this->user->user_id : $this->user->id;
        $client = $this->chechClient("400", $this->request['to']);
        $modelData = [
            'msg_id'            => 0,
            'user_id'           => $user_id,
            'client_id'         => $client->uuid,
            'type'              => $this->request['type'],
            'otp'               => $this->request['otp'],
            'status'            => $msg,
            'code'              => "400",
            'message_content'   => $this->campaign ? 'Campaign No:' . $this->campaign->id : $this->request['text'],
            'provider'          => $this->request['provider']->id,
            'price'             => 0,
            'balance'           => 0,
            'msisdn'            => $this->request['to'],
        ];
        if ($this->request['resource'] == 2) {

            $mms = Request::create([
                'source_id' => 'wachat_' . Hashids::encode($client->id),
                'reply'     => $this->campaign ? 'Campaign No:' . $this->campaign->id : $this->request['text'],
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
        $this->synCampaign($mms->id);
        return $mms;
    }

    /**
     * This to check and get client, if not found will create new
     *
     * @param  mixed $status
     * @param  mixed $msisdn
     * @return object App\Models\Client
     */
    private function chechClient($status, $msisdn = null)
    {
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

        return $client;
    }

    /**
     * synCampaign
     *
     * @param  mixed $blast
     * @return void
     */
    private function synCampaign($blastId)
    {
        if ($blastId && !is_null($this->campaign)) {
            CampaignModel::create([
                'campaign_id' => $this->campaign->id,
                'model' => 'BlastMessage',
                'model_id' => $blastId
            ]);
        }
    }
}
