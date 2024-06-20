<?php

namespace App\Jobs;

use App\Models\CampaignModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProcessCampaignApi implements ShouldQueue
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
    public function __construct($request, $user,  $campaign)
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

        if ($provider->code == 'provider3') {
            $this->WTProvider($this->request);
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
            $resData = json_decode($response, true);
            // Log::debug($resData);
            if ($resData['status']) {
                // $response = Http::withOptions(['verify' => false,])->withHeaders(['Client-Key' => ENV('WTID_CLIENT_KEY', 'MDgxMjM0NTY3Ng=='), 'Client-Secret' => ENV('WTID_CLIENT_SECRET', 'MDgxMjM0NTY3NnwyMDI0LTAxLTMwIDEwOjIyOjIw')])->patch($url . 'api/campaign/ready/' . $resData['campaign_id']);
                Log::debug($response);
                $result = json_decode($response, true);
                if ($result['status']) {
                    Log::debug("WA is OK");
                } else {
                    Log::debug("WA is ERROR: " . $result['message']);
                }
            } else {
                Log::debug("Campaign WA is FAILED: " . $resData['message']);
            }
        }
        $resData['message'] = 'Ready';
        $resData['code'] = 200;
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
