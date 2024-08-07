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
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportAudienceContact;
use App\Jobs\importAudienceContact;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads, AuthorizesRequests;

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
    public $selectTo = 'manual';
    public $listProvider;
    public $listChannel;
    public $userProvider;
    public $selectedProviderCode;
    public $templates;
    public $template_id;
    public $formName;
    public $fromList;
    public $hasSchedule = false;
    public $showModal = false;
    protected $cacheDuration = 3600;
    public $file;


    /**
     * mount
     *
     * @param  mixed $campaign
     * @return void
     */
    public function mount($campaign)
    {
        $campaign = Campaign::find($campaign);
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
        if ($this->audience_id) {
            $this->selectTo = 'audience';
        }

        $this->audience = Audience::withCount('audienceClients')->get();

        $this->userProvider = ProviderUser::with('provider')
            ->where('user_id', auth()->user()->id)
            ->get();

        $selectProvider = [];
        $selectChannel = [];
        foreach($this->userProvider as $key => $up){
            $selectProvider[$key] = [$up->provider->code, $up->provider->name];
            $selectChannel[$key] = [$up->channel, $up->provider->code];
        }
        $this->listProvider = $selectProvider;
        $this->listChannel = $selectChannel;

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

    /**
     * checkSchedule
     *
     * @return void
     */
    public function checkSchedule()
    {
        $this->hasSchedule = CampaignSchedule::where('campaign_id', $this->campaign_id)->exists();
    }

    /**
     * updatedSelectTo
     *
     * @return void
     */


    /**
     * loadAudienceContacts
     *
     * @return void
     */
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

    /**
     * updatedAudienceId
     *
     * @param  mixed $value
     * @return void
     */
    public function updatedAudienceId($value)
    {
        $this->audience_id = $value;
        $this->loadAudienceContacts();
    }

    /**
     * updatedProvider
     *
     * @param  mixed $providerCode
     * @return void
     */
    public function updatedProvider($providerCode)
    {

        // // dd($providerCode);
        // $selectedProvider = $this->userProvider->firstWhere('provider.code', $providerCode);
        // // dd($this->listProvider);
        // $this->channel = $selectedProvider ? $selectedProvider->channel : '';
        // $this->loadAudienceContacts();
        // $this->getFrom();
    }

    /**
     * updatedProvider
     *
     * @param  mixed $providerCode
     * @return void
     */
    public function updatedChannel($channel)
    {
        $selectedProvider = $this->userProvider->firstWhere('channel', $channel);
        // dd($selectedProvider);
        $this->provider = $selectedProvider ? $selectedProvider->provider->code : '';
        $this->loadAudienceContacts();
        $this->getFrom();
    }

    /**
     * getFrom
     *
     * @return void
     */
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

    /**
     * startCampaign
     *
     * @return void
     */
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


            //UPDATE STATUS
            $this->campaign->status = 'started';
            $this->campaign->save();
            $this->showModal = false;

            //START EXECUTE SENDING MESSAGE IF NO SCHEDULE
            if ($this->campaign->status == 'started' && $this->campaign->shedule_type=='none') {
                // session()->flash('error', 'Campaign must have at least one schedule.');
                // $this->showModal = false;
                // return;
                $this->campaign->status = 'processing';
                $this->campaign->save();

                $channel = $this->campaign->channel;
                $provider = cache()->remember('provider-user-' . auth()->user()->id . '-' . $channel, $this->cacheDuration, function () use ($channel) {
                    return auth()->user()->providerUser->where('channel', strtoupper($channel))->first()->provider;
                });
                // START TO HIT CREATE CAMPAIGN API
                if ($provider->code == 'provider3') {
                    //EXPORT FILE EXCEL AUDIENCE
                    Excel::store(new ExportAudienceContact($this->audience_id), $this->campaign_id . '_campaign.xlsx');
                    //RUN JOB CAMPAIGN API
                    $url = ENV('WTID_URL', '6005');
                    $response = Http::withOptions(['verify' => false,])
                        ->withHeaders([
                            'Client-Key' => ENV('WTID_CLIENT_KEY', 'MD--=='),
                            'Client-Secret' => ENV('WTID_CLIENT_SECRET', 'MD--Q1')
                        ])
                        ->attach('campaign_receiver', file_get_contents(storage_path('app\\' . $this->campaign_id . '_campaign.xlsx')), $this->campaign_id . '_campaign.xlsx')
                        ->post($url . 'api/campaign/create', [
                            'campaign_name' => $this->campaign->title,
                            'campaign_text' => $this->campaign->text,
                        ]);
                    $resData = json_decode($response, true);
                    Log::debug($resData);
                    if ($resData['status']) {
                        $response = Http::withOptions(['verify' => false,])->withHeaders(['Client-Key' => ENV('WTID_CLIENT_KEY', 'MDg3Ng=='), 'Client-Secret' => ENV('WTID_CLIENT_SECRET', 'MDgxMjM0NTY')])->patch($url . 'api/campaign/ready/' . $resData['campaign_id']);
                        // Log::debug($response);
                        $result = json_decode($response, true);
                        if ($result['status']) {
                            Log::debug("Campaign is Ready to Publish");
                        } else {
                            Log::debug("Campaign WA is FAILED : " . $result['message']);
                        }
                    } else {
                        Log::debug("Campaign WA is FAILED: " . $resData['message']);
                    }
                }
                $audience = Audience::find($this->audience_id);
                // ADD BLAST DATA TO HIREACH
                foreach ($audience->audienceClients as $client) {
                    $data = [
                        'provider' => $provider,
                        'to' => $this->campaign->channel == 'email' ? $client->client->email : $client->client->phone,
                        'type' => $this->campaign->type,
                        'otp' => $this->campaign->is_otp,
                        'text' => 'Campaign No:' . $this->campaign->id,
                    ];
                    $this->callJobResource($data);
                }
                // ALL OK START THE CAMPAIGN API
                if ($provider->code == 'provider3') {
                }

            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->showModal = false;
            throw $e;
        }
    }

    /**
     * pauseCampaign
     *
     * @return void
     */
    public function pauseCampaign()
    {
        $this->campaign->status = 'pause';
        $this->campaign->save();
    }

    /**
     * update
     *
     * @param  mixed $id
     * @param  mixed $formName
     * @return void
     */
    public function update($id, $formName = 'basic')
    {
        $this->formName = $formName;
        $this->validate();
        if ($this->file) {
            $filePath = $this->file->getRealPath();

            $mimeType = $this->file->getClientMimeType();
            $data = [];

            if ($mimeType == 'text/csv') {
                $fileContents = file($filePath);
                foreach ($fileContents as $key => $line) {
                    if ($key > 0) {
                        $data[] = str_getcsv($line);
                    }
                }
            } else {
                $rows = Excel::toArray([], $filePath)[0];
                foreach ($rows as $key => $row) {
                    if ($key > 0) {
                        $data[] = $row;
                    }
                }
            }

            if (empty($this->audience_id)) {
                $this->audience = Audience::create([
                    'name' => $this->title,
                    'description' => 'This Audience Created Automatically at Campaign',
                    'user_id' => auth()->user()->id,
                ]);
                $this->audience_id = $this->audience->id; // Set audience_id to the created audience's ID
            }
            $this->selectTo = 'audience';

            // Ensure $this->audience_id is set correctly
            $data = importAudienceContact::dispatch($data, $this->audience_id, auth()->user()->id);
        }

        $campaign = Campaign::where('id', $id)->where('user_id', auth()->user()->id)->firstOrFail();

    $campaign->update([
            'title' => strip_tags(filterInput($this->title)),
            'type' => strip_tags(filterInput($this->type)),
            'way_type' => strip_tags(filterInput($this->way_type)),
            'budget' => strip_tags(filterInput($this->budget)),
            'is_otp' => $this->is_otp,
            'provider' => strip_tags(filterInput($this->provider)),
            'audience_id' => strip_tags(filterInput($this->audience_id)),
            'template_id' => strip_tags(filterInput($this->template_id)),
            'channel' => strip_tags(filterInput($this->channel)),
            'text' => strip_tags(filterInput($this->text)),
            'from' => strip_tags(filterInput($this->from)),
            'to' => $this->audience_id ? 'Audience-' . strip_tags(filterInput($this->audience_id)) : strip_tags(filterInput($this->to)),
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

    /**
     * updatedTemplateId
     *
     * @param  mixed $value
     * @return void
     */
    public function updatedTemplateId($value)
    {
        $this->text = '';
        $this->template_id = $value;

        if ($value == 0) {
            return;
        }

        $template = Template::with('actions')->find($value);
        foreach ($template->actions as $action) {
            $this->text = $this->text . '<div class="bg-green-200 p-3 rounded-lg my-4">' . $action->message . '</div>';
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
        }elseif (strtolower($this->campaign->channel) == 'long_wa') {
            ProcessWaApi::dispatch($data, auth()->user());
        } elseif (strtolower($this->campaign->channel) == 'long_sms') {
            ProcessSmsApi::dispatch($data, auth()->user());
        }
    }

    public function render()
    {
        $this->authorize('VIEW_RESOURCE_USR', $this->campaign->user_id);
        return view('livewire.campaign.edit');
    }
}
