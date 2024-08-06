<?php

namespace App\Jobs;

use App\Models\BlastMessage;
use App\Models\Campaign;
use App\Models\CampaignModel;
use App\Models\Client;
use App\Models\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Vinkla\Hashids\Facades\Hashids;

class ProcessEmailApi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $user;
    public $log;
    public $campaign;


    /**
     * __construct
     *
     * @param  mixed $request
     * @param  mixed $user
     * @param  mixed $log
     * @param  mixed $campaign
     * @return void
     */
    public function __construct($request, $user, $log = null, $campaign = null)
    {
        $this->data = $request;
        $this->user = $user;
        $this->log = $log;
        $this->campaign = $campaign;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //filter OTP & Non OTP
        $provider = $this->data['provider'];
        if ($provider->code == 'provider1') {
            $this->FreeProvider($this->data);
        } elseif ($provider->code == 'provider2') {
            $this->PaidProvider($this->data);
        }
    }

    /**
     * sendEmail
     *
     * @param  mixed $request
     * @return void
     */
    private function sendEmail($request)
    {
        if ($request['type'] >= "0") {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json"
            ));
            curl_setopt(
                $curl,
                CURLOPT_URL,
                "https://api.smtp2go.com/v3/email/send"
            );
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array(
                "api_key" => env('SMTP2GO_API_KEY', 'A'),
                "sender" => $request['from'] == '' ? $request['from'] : "noreply@hireach.archeeshop.com",
                "to" => array(
                    0 => $request['to']
                ),
                "subject" => $request['title'],
                "html_body" => "<h1>" . $request['text'] . "</h1>",
                "text_body" => $request['text']
            )));
            $result = curl_exec($curl);
            return $result;
            //echo $result;
        }
    }
    /**
     * FreeProvider
     *
     * @param  mixed $request
     * @return void
     */
    private function FreeProvider($request)
    {
        $msg    = '';
        // if(array_key_exists('servid', $request)){
        //     $serve  = $request['servid'];
        // }
        if (true) {
            Log::debug('start job sending email');
            // Log::debug($request);
            $response = '';

            // return $response;
            //Log::debug("MK Res:");

            if (App::environment('production')) {
                $result = $this->sendEmail($request);
            } elseif (App::environment(['local', 'testing'])) {
                // Attempt to get the response from the first URL
                $response = Http::get(url('http://hireach.test/api/dummy-json'));

                if (!$response->successful()) {
                    $response = Http::get(url('http://127.0.0.1:8000/api/dummy-json'));
                }
                $result = $response->body();
            } elseif (App::environment('development')) {
                $response = Http::get('https://hireach.archeeshop.com/dummy-json');
                $result = $response->body();
            }

            Log::debug($result);
            $response = json_decode($result, true);
            // Log::debug($response);
            // $response=$result['data']['succeeded'];
            // $failed=$result['data']['failed'];

            if (is_array($response) && array_key_exists('failed', $response['data']) && $response['data']['failed'] == 1) {
                $msg = $response['data']['failures'];
                Campaign::find($this->campaign->id)->update(['status' => 'failed']);
            } elseif (is_array($response) && array_key_exists('request_id', $response)) {
                $balance = 0;
                $client = $this->chechClient("200", $request['to']);
                //check client && array
                $modelData = [
                    'title'     => $request['title'],
                    'msg_id'    => $response['request_id'],
                    'user_id'   => $this->user->id,
                    'client_id' => $client->uuid,
                    'sender_id' => $request['from'],
                    'type'      => $request['type'],
                    'otp'       => $request['otp'],
                    'status'    => "SUCCESS",
                    'code'      => 200,
                    'message_content'  => $request['text'],
                    'currency'  => 'IDR',
                    'price'     => 0,
                    'balance'   => $balance,
                    'msisdn'    => $request['to'],
                    'provider' => $this->data['provider']->id
                ];
                // Log::debug($modelData);
                if (array_key_exists('resource', $this->data) && $this->data['resource'] == 2) {
                    $bm = Request::create([
                        'source_id' => 'emailchat_' . Hashids::encode($client->id),
                        'reply'     => $request['text'],
                        'from'      => $client->id,
                        'user_id'   => $this->user->id,
                        'type'      => 'text',
                        'client_id' => $client->uuid,
                        'sent_at'   => date('Y-m-d H:i:s'),
                        'team_id'   => $request['team_id']
                    ]);
                } else {
                    $bm = BlastMessage::create($modelData);
                }
                $this->synCampaign($bm);
            }
            // Log::debug("Respone MSG:");
            // Log::debug($msg);
            if ($msg != '' || is_null($response)) {
                $this->saveResult($msg);
            }
        } else {
            $this->saveResult('Reject invalid servid');
        }
    }

    /**
     * PaidProvider
     *
     * @param  mixed $request
     * @return void
     */
    private function PaidProvider($request)
    {
        $msg = $this->saveResult('progress');
        if (true) {
            $response = '';


            if (App::environment('production')) {
                $result = $this->sendEmail($request);
            } elseif (App::environment(['local', 'testing'])) {
                // Attempt to get the response from the first URL
                $response = Http::get(url('http://hireach.test/api/dummy-json'));

                if (!$response->successful()) {
                    $response = Http::get(url('http://127.0.0.1:8000/api/dummy-json'));
                }
                $result = $response->body();
            } elseif (App::environment('development')) {
                $response = Http::get('https://hireach.archeeshop.com/dummy-json');
                $result = $response->body();
            }

            // return $response;
            //Log::debug("MK Res:");
            //Log::debug($result);
            $result = json_decode($result, true);
            // check response code
            $success = $result['data']['succeeded'];
            $failed = $result['data']['failed'];

            if ($failed >= 1) {
                $msg = $result['data']['failures'];
                Campaign::find($this->campaign->id)->update(['status' => 'failed']);
            } else {
                $balance = 0;
                $client = $this->chechClient("200", $request['to']);
                //check client && array
                $modelData = [
                    'title'     => $request['title'],
                    'msg_id'    => $result['request_id'],
                    'user_id'   => $this->user->id,
                    'client_id' => $client->uuid,
                    'sender_id' => $request['from'],
                    'type'      => $request['type'],
                    'otp'       => $request['otp'],
                    'status'    => "SUCCESS",
                    'code'      => 200,
                    'message_content'  => $request['text'],
                    'currency'  => 'IDR',
                    'price'     => 0,
                    'balance'   => $balance,
                    'msisdn'    => $request['to'],
                    'provider' => $this->data['provider']->id
                ];
                // Log::debug($modelData);
                if ($this->data['resource'] == 2) {
                    $bm = Request::create([
                        'source_id' => 'emailchat_' . Hashids::encode($client->id),
                        'reply'     => $request['text'],
                        'from'      => $client->id,
                        'user_id'   => $this->user->id,
                        'type'      => 'text',
                        'client_id' => $client->uuid,
                        'sent_at'   => date('Y-m-d H:i:s'),
                        'team_id'   => auth()->user()->currentTeam->id
                    ]);;
                } else {
                    $bm = BlastMessage::create($modelData);
                }
                $this->synCampaign($bm);
            }
            // Log::debug("Respone MSG:");
            // Log::debug($msg);
            if ($msg != '') {
                $this->saveResult($msg);
            }
        } else {
            $this->saveResult('Reject invalid servid');
        }
    }

    /**
     * saveResult
     *
     * @param  mixed $msg
     * @return object BlastMessage
     */
    private function saveResult($msg)
    {
        $user_id = $this->user->id;
        $client = $this->chechClient("400");
        $modelData = [
            'title'             => $this->data['title'],
            'msg_id'            => 0,
            'user_id'           => $user_id,
            'client_id'         => $client->uuid,
            'type'              => $this->data['type'],
            'otp'               => $this->data['otp'],
            'status'            => $msg,
            'code'              => "400",
            'message_content'   => $this->data['text'],
            'price'             => 0,
            'balance'           => 0,
            'msisdn'            => $this->data['to'],
            'provider'          => $this->data['provider']->id
        ];
        if ($this->data['resource'] == 2) {
            $mms = Request::create([
                'source_id' => 'emailchat_' . Hashids::encode($client->id),
                'reply'     => $this->data['text'],
                'from'      => $client->id,
                'user_id'   => $user_id,
                'type'      => 'text',
                'client_id' => $client->uuid,
                'sent_at'   => date('Y-m-d H:i:s'),
                'team_id'   => $this->data['team_id']
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
            $client = Client::where('email', $msisdn)->where('user_id', $user_id)->firstOr(function () use ($msisdn, $user_id) {
                return Client::create([
                    'email' => $msisdn,
                    'user_id' => $user_id,
                    'uuid' => Str::uuid()
                ]);
            });
        } else {
            $phones = explode(",", $this->data['to']);
            $client = Client::where('email', $phones[0])->where('user_id', $user_id)->firstOr(function () use ($phones, $user_id) {
                return Client::create([
                    'email' => $phones[0],
                    'user_id' => $user_id,
                    'uuid' => Str::uuid()
                ]);
            });
        }
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
    private function synCampaign($blast)
    {
        if ($blast && !is_null($this->campaign)) {
            CampaignModel::create(['campaign_id' => $this->campaign->id, 'model' => 'BlastMessage', 'model_id' => $blast->id]);
        }
    }
}
