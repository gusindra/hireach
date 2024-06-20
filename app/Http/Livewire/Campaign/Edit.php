<?php

namespace App\Http\Livewire\Campaign;

use App\Jobs\ProcessEmailApi;
use App\Jobs\ProcessSmsApi;
use App\Jobs\ProcessWaApi;
use App\Models\Audience;
use App\Models\Campaign;
use App\Models\CampaignSchedule;
use App\Models\ProviderUser;
use App\Models\Template;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportAudienceContact;

class Edit extends Component
{
    public $campaign_id;
    public $campaign;
    public $title;
    public $type;
    public $way_type;
    public $budget;
    public $is_otp;
    public $provider;
    public $channel;
    public $text;
    public $from;
    public $to;
    public $audience_id;
    public $audience;
    public $selectTo = 'audience';
    public $userProvider;
    public $selectedProviderCode;
    public $templates;
    public $template_id;
    public $formName;
    public $fromList;
    public $hasSchedule = false;
    public $showModal = false;
    protected $cacheDuration = 3600;

    public function mount($campaign)
    {
        $campaign = Campaign::where('id', $campaign)->where('user_id', Auth::id())->firstOrFail();
        $this->campaign = $campaign;
        $this->campaign_id = $campaign->id;
        $this->template_id = $campaign->template_id;
        $this->title = $campaign->title;
        $this->type = $campaign->type;
        $this->way_type = $campaign->way_type;
        $this->budget = $campaign->budget;
        $this->is_otp = $campaign->is_otp;
        $this->provider = $campaign->provider;
        $this->channel = $campaign->channel;
        $this->text = $campaign->text;
        $this->from = $campaign->from;
        $this->to = $campaign->to;
        $this->audience_id = $campaign->audience_id;
        // $this->selectTo = $campaign->audience_id ? 'audience' : 'manual';
        $this->selectTo = 'audience';

        $this->audience = Audience::withCount('audienceClients')->get();

        $this->userProvider = ProviderUser::with('provider')
            ->where('user_id', auth()->user()->id)
            ->get();

        $this->userProvider->firstWhere('provider.code', $this->provider);

        $this->selectedProviderCode = $this->provider;

        $userTemplates = Template::with('question')
            ->where('user_id', auth()->user()->id)
            ->get();

        $this->templates = $userTemplates->isEmpty() ? collect() : $userTemplates;


        $this->hasSchedule = CampaignSchedule::where('campaign_id', $this->campaign_id)->exists();

        if ($this->selectTo === 'audience') {
            $this->loadAudienceContacts();
        }
        $this->fromList[1] = auth()->user()->phone_no;
        if ($this->channel == 'EMAIL') {
            $this->fromList[0] = 'noreply@hireach.archeeshop.com';
            $this->fromList[1] = auth()->user()->email;
            $this->from = 'noreply@hireach.archeeshop.com';
        } else {

            $this->fromList[0] = 'Auto';
            if (auth()->user()->phone_no) {
                $this->fromList[1] = auth()->user()->phone_no;
            }
            $this->from = 'Auto';
        }
    }

    public function checkSchedule()
    {
        $this->hasSchedule = CampaignSchedule::where('campaign_id', $this->campaign_id)->exists();
    }

    public function updatedSelectTo()
    {
        if ($this->selectTo === 'manual') {
            $this->campaign->audience_id = null;
            $this->campaign->save();

            $this->audience_id = null;
            $this->to = '';
        } else {

            $this->to = '';
        }
    }

    public function loadAudienceContacts()
    {
        if ($this->audience_id) {
            $audience = Audience::with('audienceClients.client')->find($this->audience_id);

            if ($audience) {
                if ($this->channel === 'EMAIL') {
                    $contacts = $audience->audienceClients->pluck('client.email')->toArray();
                } else {
                    $contacts = $audience->audienceClients->pluck('client.phone')->toArray();
                }
                $this->to = !empty($contacts) ? implode(',', $contacts) : '';
            } else {
                $this->to = '';
            }
        } else {
            $this->to = '';
        }
    }

    public function updatedAudienceId($value)
    {
        $this->audience_id = $value;
        $this->loadAudienceContacts();
    }

    public function updatedProvider($providerCode)
    {

        $selectedProvider = $this->userProvider->firstWhere('provider.code', $providerCode);
        $this->channel = $selectedProvider ? $selectedProvider->channel : '';
        $this->loadAudienceContacts();
        $this->getFrom();
    }

    public function getFrom()
    {
        $this->fromList[1] = auth()->user()->phone_no;
        if ($this->channel == 'EMAIL') {
            $this->fromList[0] = 'noreply@hireach.archeeshop.com';
            $this->fromList[1] = auth()->user()->email;
            $this->from = 'noreply@hireach.archeeshop.com';
        } else {

            $this->fromList[0] = 'Auto';
            if (auth()->user()->phone_no) {
                $this->fromList[1] = auth()->user()->phone_no;
            }
            $this->from = 'Auto';
        }
    }

    public function rules()
    {
        $data = [
            'title' => 'required',
            'type' => 'required',
            'way_type' => 'required',
            'budget' => 'required',
        ];

        if ($this->formName == 'provider') {
            $data = [
                'provider' => 'required',
                'channel' => 'required',
            ];
        } elseif ($this->formName == 'content') {
            $data = [
                'text' => 'required',
            ];
        } elseif ($this->formName == 'fromTo') {
            $data = [
                'from' => 'required',
                'to' => 'required',
            ];
        }

        return $data;
    }

    public function startCampaign()
    {
        try {
            // Validate the input data
            $this->validate([
                'title' => 'required',
                'type' => 'required',
                'way_type' => 'required',
                'budget' => 'required',
                'provider' => 'required',
                'channel' => 'required',
                'text' => 'required',
                'from' => 'required',
                'to' => 'required',
            ]);

            // if (!$this->hasSchedule) {
            //     session()->flash('error', 'Campaign must have at least one schedule.');
            //     $this->showModal = false;
            //     return;
            // }

            $this->campaign->status = 'started';
            $this->campaign->save();
            $this->showModal = false;

            $channel = $this->campaign->channel;
            $provider = cache()->remember('provider-user-'.auth()->user()->id.'-'.$channel, $this->cacheDuration, function() use ($channel) {
                return auth()->user()->providerUser->where('channel', strtoupper($channel))->first()->provider;
            });
            // START TO HIT CREATE CAMPAIGN API
            if($provider->code=='provider3'){
                //EXPORT FILE EXCEL AUDIENCE
                Excel::store(new ExportAudienceContact($this->audience_id), $this->campaign_id.'_campaign.xlsx');
                //RUN JOB CAMPAIGN API
            }
            $audience = Audience::find($this->audience_id);
            // ADD BLAST DATA TO HIREACH
            foreach($audience->audienceClients as $client){
                $data = [
                    'provider' => $provider,
                    'to' => $this->campaign->channel == 'email' ? $client->client->email:$client->client->phone,
                    'type' => $this->campaign->type,
                    'otp' => $this->campaign->is_otp,
                    'text' => 'Campaign No:'.$this->campaign->id,
                ];
                $this->callJobResource($data);
            }
            // ALL OK START THE CAMPAIGN API
            if($provider->code=='provider3'){

            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->showModal = false;
            throw $e;
        }
    }

    public function pauseCampaign()
    {
        $this->campaign->status = 'pause';
        $this->campaign->save();
    }

    public function update($id, $formName = 'basic')
    {
        $this->formName = $formName;
        $this->validate();

        $campaign = Campaign::where('id', $id)->where('user_id', auth()->user()->id)->firstOrFail();

        $campaign->update([
            'title' => $this->title,
            'type' => $this->type,
            'way_type' => $this->way_type,
            'budget' => $this->budget,
            'is_otp' => $this->is_otp,
            'provider' => $this->provider,
            'audience_id' => $this->audience_id,
            'template_id' => $this->template_id,
            'channel' => $this->channel,
            'text' => $this->text,
            'from' => $this->from,
            'to' => $this->to,
        ]);

        if ($formName == 'provider') {
            $this->emit('savedProvider');
        } elseif ($formName == 'content') {
            $this->emit('savedContent');
        } elseif ($formName == 'fromTo') {
            $this->emit('savedFromTo');
        } else {
            $this->emit('saved');
        }
    }

    public function updatedTemplateId($value)
    {
        $this->text = '';
        $this->template_id = $value;

        if ($value == 0) {
            return;
        }

        $template = Template::with('actions')->find($value);
        foreach ($template->actions as $action) {
            $this->text .= <<<HTML
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 my-4 rounded-lg shadow-md">
                <p class="font-semibold">{$action->message}</p>
            </div>
            HTML;
        }
    }

    /**
     * callJobResource
     *
     * @param  mixed $data
     * @param  mixed $credential
     * @return json
     */
    public function callJobResource($data, $credential = null)
    {
        if ($this->campaign->channel == 'email') {
            //THIS WILL QUEUE EMAIL JOB
            $reqArr = json_encode($data);
            ProcessEmailApi::dispatch($data, auth()->user(), $reqArr, $this->campaign);
        } elseif (strpos($this->campaign->channel, 'sms') !== false) {
            ProcessSmsApi::dispatch($data, auth()->user(), $this->campaign);
        } elseif (strpos(strtolower($this->campaign->channel), 'wa') !== false) {
            if (!is_null($credential)) {
                ProcessWaApi::dispatch($data, $credential, $this->campaign);
            } else {
                ProcessWaApi::dispatch($data, auth()->user(), $this->campaign);
            }
        } elseif ($this->campaign->channel == 'wa') {
            //ProcessChatApi::dispatch($request->all(), auth()->user());
        }
    }

    public function render()
    {
        return view('livewire.campaign.edit');
    }
}
