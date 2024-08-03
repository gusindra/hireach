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

class ProcessCampaignSchedule implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
    public function __construct($campaign)
    {
        $this->campaign = $campaign;
    }

    /**
     * Execute the job to processing WA.
     *
     * @return void
     */
    public function handle()
    {
        if($this->campaign && ($this->campaign->to != '' || $this->campaign->audience_id)){
            $contact = $this->campaign->to != '' && !str_contains( $this->campaign->to, 'Audience') ? explode(',', $this->campaign->to) : $this->campaign->audience->audienceClients;
            $data = [
                'resource' => $this->campaign->way_type,
                'type' => $this->campaign->type,
                'from' => $this->campaign->from,
                'text' => $this->campaign->text,
                'title' => $this->campaign->title,
                'otp' => $this->campaign->otp ? 1 : 0
            ];
            $user = $this->campaign->user;
            $data['provider'] = $user->providerUser->where('channel', strtoupper($this->campaign->channel))->first()->provider;

            if($this->campaign->template_id!=NULL){
                $data['templateid'] = $this->campaign->template_id;
            }

            $credential = null;
            if (strtolower($this->campaign->channel) == 'wa') {
                $credential = $user->credential->firstWhere('client', 'api_wa_mk');
            }

            foreach ($contact as $c) {
                if($this->campaign->channel == 'EMAIL'){
                    $data['to'] = $c->client->email;
                }else{
                    $data['to'] = $c->client->phone;
                }

                if($this->campaign->channel == 'EMAIL'){
                    ProcessEmailApi::dispatch($data,  $user, null, $this->campaign);
                } elseif(strpos(strtolower($this->campaign->channel), 'sms') !== false) {
                    ProcessSmsApi::dispatch($data,  $user, $this->campaign);
                } elseif (strtolower($this->campaign->channel) == 'wa') {
                    if ($credential){
                        ProcessWaApi::dispatch($data, $credential, $this->campaign);
                    }else{
                        Log::debug('ProcessWaApi for campaign '.$this->campaign->id.' not handle without user credential');
                    }
                }elseif (strtolower($this->campaign->channel) == 'long_wa') {
                    ProcessWaApi::dispatch($data, $user, $this->campaign);
                } elseif (strtolower($this->campaign->channel) == 'long_sms') {
                    ProcessSmsApi::dispatch($data, $user, $this->campaign);
                }
            }
        }
    }
}
