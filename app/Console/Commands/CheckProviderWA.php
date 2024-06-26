<?php

namespace App\Console\Commands;

use App\Models\User;
use CURLFile;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckProviderWA extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:wa {provider}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to check provider WhatsApp status';

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

        if ($this->argument('provider') == 'enjoymov') {
            $this->enjoymov($request);
        } elseif ($this->argument('provider') == 'macrokiosk') {
            $this->macrokiosk($request);
        } elseif ($this->argument('provider') == 'wetalkid') {
            $this->wetalkid($request);
        }
    }

    /**
     * enjoymov
     *
     * @param  mixed $request
     * @return void
     */
    private function enjoymov($request)
    {
        $url = 'https://enjoymov.co/prod-api/kstbCore/sms/send';
        $md5_key = env('EM_MD5_KEY', 'A'); //'AFD4274C39AB55D8C8D08FA6E145D535';
        $merchantId = env('EM_MERCHANT_ID', 'A'); //'KSTB904790';
        $callbackUrl = 'http://hireach.firmapps.ai/receive-sms-status';
        $content = $request['text'];
        $msgChannel = env('EM_CODE_LSMS', 80);
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
        $response = Http::withBody(json_encode($data), 'application/json')->withOptions(['verify' => false,])->post($url);
        $resData = json_decode($response, true);
        if ($resData['message'] == 'Success') {
            $this->line("WA is OK");
        } else {
            $this->line("WA is ERROR");
        }
    }

    /**
     * macrokiosk
     *
     * @param  mixed $request
     * @return void
     */
    private function macrokiosk($request)
    {
        //$url = 'http://www.etracker.cc/bulksms/mesapi.aspx';
        $url = 'https://www.etracker.cc/OTT/api/Send';
        $sid    = "AC6c598c40bbbb22a9c3cb76fd7baa67b8";
        $token  = "500107131bbdb25dee1992053e93409f";
        $send_to =  $request['to'];
        $user = User::find(2);
        $username = $user->credential;
        $password = $user->api_key;
        $service = $user;

        if ($request['type'] == 1) {
            if ($request['text']  && !$request['templateid']) {
                $str = $request['reply'];
                $pattern = "/(http)/i";
                $status_url = false;
                if (preg_match($pattern, $str)) {
                    $status_url = true;
                }
                $response = Http::withBasicAuth($service->credential, $password)->accept('application/xml')->post($url, [
                    'channel' => 'whatsapp',
                    'from' =>  $service->server_key,
                    'recipient' => $request['phone'],
                    'type' => 'text',
                    'text' => [
                        "body" => $request['reply']
                    ],
                    'preview_url' => $status_url
                ]);
            } else {
                $response = Http::withBasicAuth($username, $password)->accept('application/xml')->post($url, [
                    'channel' => 'whatsapp',
                    'from' =>  $service->user->name,
                    'recipient' => $request['phone'],
                    'type' => 'template',
                    "template" => [
                        "name" => "welcome",
                        "ttl" => 3,
                        "language_code" => "EN",
                        "template_params" => [
                            [
                                "value" => $request['name']
                            ],
                        ]
                    ]
                ]);
            }
        }
    }

    /**
     * wetalkid
     *
     * @param  mixed $request
     * @return void
     */
    private function wetalkid($request)
    {
        $url = 'https://45.118.134.84:6005/';
        // $curl = curl_init();

        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => $url.'api/campaign/create',
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => '',
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 0,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => 'POST',
        //     CURLOPT_POSTFIELDS => array(
        //         'campaign_name' => 'Testing API from HiReach',
        //         'campaign_text' => 'Hallo testing 1',
        //         'campaign_receiver'=> new CURLFile(storage_path('app/template_contact_wetalk.xlsx'))
        //     ),
        //     CURLOPT_HTTPHEADER => array(
        //         'Client-Key: MDgzMTUyNDU1NTU1NA==',
        //         'Client-Secret: MDgzMTUyNDU1NTU1NHwyMDI0LTA1LTI5IDA4OjMwOjQ1'
        //     ),
        // ));

        // $response = curl_exec($curl);
        $response = Http::withOptions(['verify' => false,])
        ->withHeaders([
            'Client-Key' => ENV('WTID_CLIENT_KEY', 'MDgxMjM0NTY3Ng=='),
            'Client-Secret' => ENV('WTID_CLIENT_SECRET', 'MDgxMjM0NTY3NnwyMDI0LTAxLTMwIDEwOjIyOjIw')])
        ->attach('campaign_receiver', file_get_contents(storage_path('app\template_contact_wetalk.xlsx')), 'template_contact_wetalk.xlsx')
        ->post($url . 'api/campaign/create', [
            'campaign_name' => 'Testing API from HiReach',
            'campaign_text' => 'Hallo testing 1',
            // 'campaign_receiver' => new CURLFile(storage_path('app\template_contact_wetalk.xlsx'))
        ]);

        Log::debug($response);
        $resData = json_decode($response, true);
        Log::debug($resData);
        //curl_close($curl);

        if ($resData['status']) {
            $response = Http::withOptions(['verify' => false,])->withHeaders(['Client-Key' => ENV('WTID_CLIENT_KEY', 'MDgxMjM0NTY3Ng=='), 'Client-Secret' => ENV('WTID_CLIENT_SECRET', 'MDgxMjM0NTY3NnwyMDI0LTAxLTMwIDEwOjIyOjIw')])->patch($url . 'api/campaign/ready/' . $resData['campaign_id']);
            Log::debug($response);
            $result = json_decode($response, true);
            if ($result['status']) {
                $this->line("WA is OK");
            } else {
                $this->line("WA is ERROR: " . $result['message']);
            }
        } else {
            $this->line("Campaign WA is FAILED: " . $resData['message']);
        }
    }
}
