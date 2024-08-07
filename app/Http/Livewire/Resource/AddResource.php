<?php

namespace App\Http\Livewire\Resource;

use App\Jobs\ProcessChatApi;
use App\Jobs\ProcessEmailApi;
use App\Jobs\ProcessSmsApi;
use App\Jobs\ProcessWaApi;
use App\Models\Audience;
use App\Models\AudienceClient;
use App\Models\Campaign;
use App\Models\Client;
use App\Models\ProviderUser;
use App\Models\Request;
use Livewire\Component;
use App\Models\Template;
use Illuminate\Support\Facades\Auth;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Str;

class AddResource extends Component
{
    public $resource;
    public $template;
    public $templateId;
    public $is_enabled;
    public $is_waiting;
    public $uuid;
    public $channel;
    public $provider;
    public $bound;
    public $title;
    public $text;
    public $from;
    public $type;
    public $otp;

    public $to;
    public $providers;
    public $selectTo;
    public $selectedAudience;
    public $audienceDetail;
    public $modal;
    public $clients = [];
    public $fromList = [];
    public $modalActionVisible = false;
    public $input;
    public $contactArray = [];
    public $audiences = [];
    public $selectedContact = '';
    public $search = '';


    /**
     * mount
     *
     * @param  string $uuid
     * @param  boolean $modal
     * @return void
     */
    public function mount($uuid, $modal = false)
    {

        $user = Auth::user();
        $this->resource = $uuid;
        $this->template = Template::with('question')->where('uuid', $uuid)->first();
        $this->channel = $this->channel ? $this->channel : '';
        $this->is_enabled = $this->template ? $this->template->is_enabled : '';
        $this->is_waiting = $this->template ? $this->template->is_wait_for_chat : '';
        $this->templateId = $this->template ? $this->template->id : '';
        $this->from = auth()->user()->email;
        $this->templateId =  '0';
        $this->selectTo = 'manual';
        $this->modal = $modal;
        $this->otp;
        if ($this->resource == 2) {
            $this->bound = 'out';
        }
        if ($user) {
            $this->providers = ProviderUser::where('user_id', $user->id)->get();
        }

        $this->contactArray = Client::orderBy('created_at', 'desc')->where('user_id', auth()->user()->currentTeam->user_id)->limit(5)->get();
        $this->audiences = Audience::orderBy('created_at', 'desc')->where('user_id', auth()->user()->currentTeam->user_id)->limit(5)->get();
    }

    /**
     * updatedSearch
     *
     * @return void
     */
    public function updatedSearch()
    {
        $this->emit('loading');
        $this->selectedContact = "";

        $channel = $this->channel;

        if ($this->selectTo == 'from_audience') {
            if ($this->search) {
                $this->audiences = Audience::where('name', 'like', '%' . $this->search . '%')
                    ->where('user_id', auth()->user()->id)
                    ->limit(5)
                    ->get();
            } else {
                $this->audiences =  Audience::orderBy('created_at', 'desc')->where('user_id', auth()->user()->currentTeam->user_id)->limit(5)->get();
            }
        } elseif ($this->selectTo == 'from_contact') {
            if ($this->search) {
                $this->contactArray = Client::where(function ($query) use ($channel) {
                    if ($channel == 'email') {
                        $query->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('email', 'like', '%' . $this->search . '%');
                    } else {
                        $query->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('email', 'like', '%' . $this->search . '%')
                            ->orWhere('phone', 'like', '%' . $this->search . '%');
                    }
                })
                    ->where('user_id', auth()->user()->id)
                    ->limit(5)
                    ->get();
            } else {

                $this->contactArray =  Client::orderBy('created_at', 'desc')->where('user_id', auth()->user()->currentTeam->user_id)->limit(5)->get();
            }
        }
    }


    /**
     * selectAudience
     *
     * @param  mixed $id
     * @return void
     */
    public function selectAudience($id)
    {
        $this->audienceDetail = Audience::find($id);
        $this->selectedAudience = $id;
        $this->search = $this->audienceDetail->name;

        if ($id) {
            $selectedAudienceId = $this->selectedAudience;

            $clientIds = AudienceClient::where('audience_id', $selectedAudienceId)->pluck('client_id');
            if ($this->channel == 'email') {
                $this->to = Client::whereNotNull('email')->whereIn('uuid', $clientIds)->pluck('email')->implode(',');
            } elseif ($this->channel != 'email') {
                $this->to = Client::whereNotNull('phone')->whereIn('uuid', $clientIds)->pluck('phone')->implode(',');
            }
        } else {
            $this->clients = [];
        }
    }

    public function loadDefaultContacts()
    {
        $this->contactArray = Client::orderBy('created_at', 'desc')->where('user_id', auth()->user()->currentTeam->user_id)->take(5)->get();
    }

    /**
     * selectContact
     *
     * @param  mixed $value
     * @return void
     */
    public function selectContact($value)
    {

        // dd($value);
        $this->selectedContact = "";
        if ($value != "") {
            $this->selectedContact = $value;
            $this->search = $value;
            $this->contactArray = [];
            if ($this->channel == 'email') {
                $this->to = $value;
            } else {
                $this->to = $value;
            }
        } else {
            $this->search = "";
        }
        // dd($value);
    }

    /**
     * actionShowModal
     *
     * @return void
     */
    public function actionShowModal()
    {
        $this->modalActionVisible = true;
    }

    /**
     * rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            'channel' => 'required',
            'from' => 'required',
            'to' => 'required',
            'title' => 'required',
            'text' => 'required',
        ];
    }

    /**
     * modelData
     *
     * @return array
     */
    public function modelData()
    {
       return [
        'name' => strip_tags(filterInput($this->name)),
        'description' => strip_tags(filterInput($this->description)),
        'is_enabled' => $this->is_enabled,
        'is_wait_for_chat' => strip_tags(filterInput($this->is_waiting)),
    ];
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
        $this->templateId = $value;
        $template = Template::with('actions')->find($value);
        foreach ($template->actions as $action) {
            $this->text = $this->text . '<div class="bg-green-200 p-3 rounded-lg">' . $action->message . '</div>';
        }
    }

    /**
     * This to send message Resource using panel form
     *
     * @return void
     */
    public function sendResource()
    {
        $this->validate();
        if ($this->selectTo === 'manual') {
            $to = $this->to;
        } elseif ($this->selectTo === 'from_contact') {
            $to = $this->selectedContact;
        } elseif ($this->selectTo == 'from_audience') {
            $selectedAudienceId = $this->selectedAudience;
            $clientIds = AudienceClient::where('audience_id', $selectedAudienceId)->pluck('client_id');

            if ($this->channel == 'email') {
                $to = Client::whereNotNull('email')->whereIn('uuid', $clientIds)->pluck('email')->implode(',');
            } elseif ($this->channel != 'email') {
                $to = Client::whereNotNull('phone')->whereIn('uuid', $clientIds)->pluck('phone')->implode(',');
            }
        }
        $to = $this->to;
        $credential = null;
        $channel = $this->channel;
        $type = $this->type;
        $title = $this->title;
        $text = $this->text;
        $templateid = $this->templateId;
        $from = $this->from;
        $provider = $this->provider;
        $otp = $this->is_enabled;

        //SET PROVIDER BASE ON THE SETTING OR AUTO SELECT DEFAULT PROVIDER
        $provider = $this->provider = auth()->user()->providerUser->where('channel', strtoupper($this->channel))->first()->provider;

        if ($provider->code == 'provider2') {
            $this->provider = 'provider2';
        } elseif ($provider->code == 'provider1') {
            $this->provider = 'provider2';
        }

        $contact = explode(',', $to);
        //SENDING RESOURCE
        if ($templateid) {
            //set text using template
            $template = Template::find($templateid);
            foreach ($template->actions as $key => $action) {

                // send request using template prt action
              $data[$key] = [
                'channel' => strip_tags(filterInput($channel)),
                'type' => 0,
                'title' => strip_tags(filterInput($title)),
                'text' => strip_tags(filterInput($action->message)),
                'templateid' => strip_tags(filterInput($templateid)),
                'to' => strip_tags(filterInput($to)),
                'from' => strip_tags(filterInput($from)),
                'resource' => strip_tags(filterInput($this->resource)),
                'provider' => strip_tags(filterInput($provider)),
                'otp' => checkContentOtp(strip_tags(filterInput($action->message)))
            ];

            }
        } else {
            $data = [
            'channel' => strip_tags(filterInput($this->channel)),
            'type' => 0,
            'title' => strip_tags(filterInput($this->title)),
            'text' => strip_tags(filterInput($this->text)),
            'templateid' => strip_tags(filterInput($this->templateid)),
            'to' => strip_tags(filterInput($this->to)),
            'from' => strip_tags(filterInput($this->from)),
            'resource' => strip_tags(filterInput($this->resource)),
            'provider' => strip_tags(filterInput($this->provider)),
            'otp' => checkContentOtp($this->text)
        ];
        }

        if ($this->resource == '2') {
            $data['team_id'] = auth()->user()->currentTeam->id;
        }
        //dd($data);

        if (strpos($this->channel, 'wa') !== false && $provider->code == 'provider1') {
            foreach (auth()->user()->credential as $cre) {
                if ($cre->client == 'api_wa_mk') {
                    $credential = $cre;
                }
            }
        }

        //ONEWAY BLAST
        if (count($contact) > 1) {
            //GROUP RETRIVER
            $this->campaignAdd($data);
            foreach ($contact as $p) {
                $data['to'] = $p;
                if ($template) {
                    // PLEASE CHECK THIS CODE
                    foreach ($data as $da) {
                        $da['to'] = $p;
                        $this->callJobResource($da, $credential);
                    }
                } else {
                    $data['to'] = $p;
                    $this->callJobResource($data, $credential);
                }
            }
        } else {
            //SINGLE RETRIVER
            if ($templateid) {
                foreach ($data as $da) {
                    $this->callJobResource($da, $credential);
                }
            } else {
                $this->callJobResource($data, $credential);
            }
        }

        $this->emit('resource_saved');
    }

    /**
     * callJobResource
     *
     * @param  mixed $data
     * @param  mixed $credential
     * @return void
     */
    public function callJobResource($data, $credential = null)
    {
        if ($this->channel == 'email') {
            //THIS WILL QUEUE EMAIL JOB
            $reqArr = json_encode($data);

            ProcessEmailApi::dispatch($data, auth()->user(), $reqArr);
        } elseif (strpos($this->channel, 'sms') !== false) {

            ProcessSmsApi::dispatch($data, auth()->user());
        } elseif (strpos(strtolower($this->channel), 'wa') !== false) {

            if ($credential) {
                ProcessWaApi::dispatch($data, $credential);
            } else {
                ProcessWaApi::dispatch($data, auth()->user());
            }
        } elseif ($this->channel == 'wa') {
            //ProcessChatApi::dispatch($request->all(), auth()->user());
        } elseif ($this->channel == 'webchat') {
            $user_id = auth()->user()->id;
            //ModelsRequest::create($modelData);
            $client = $this->chechClient("400", $data);
            Request::create([
                'source_id' => 'webchat_' . Hashids::encode($client->id),
                'reply'     => 'blast',
                'from'      => $client->id,
                'user_id'   => $user_id,
                'type'      => 'text',
                'client_id' => $client->uuid,
                'sent_at'   => date('Y-m-d H:i:s'),
                'team_id'   => auth()->user()->currentTeam->id
            ]);
        }
        //add wa long number
        //add sms long number
    }

    /**
     * updatedSelectTo
     *
     * @return void
     */
    public function updatedSelectTo()
    {
        $this->reset('to');
        $this->reset('search');
    }

    /**
     * updatedSelectedContact
     *
     * @return void
     */
    public function updatedSelectedContact()
    {
        $this->to = $this->selectedContact;
    }

    /**
     * updatedSelectedAudience
     *
     * @param  mixed $audienceId
     * @return void
     */
    public function updatedSelectedAudience($audienceId)
    {
        if ($audienceId) {
            $selectedAudienceId = $this->selectedAudience;

            $clientIds = AudienceClient::where('audience_id', $selectedAudienceId)->pluck('client_id');
            if ($this->channel == 'email') {
                $this->to = Client::whereNotNull('email')->whereIn('uuid', $clientIds)->pluck('email')->implode(',');
            } elseif ($this->channel != 'email') {
                $this->to = Client::whereNotNull('phone')->whereIn('uuid', $clientIds)->pluck('phone')->implode(',');
            }
            dd($this->to);
        } else {
            $this->clients = [];
        }
    }

    /**
     * chech client for resource 2
     *
     * @param  mixed $status
     * @param  mixed $request
     * @return object App\Models\Client
     */
    private function chechClient($status, $request = null)
    {
        $user_id = auth()->user()->id;
        $request['email'] = strpos($request['to'], '@') ? $request['to'] : '';
        $request['phone'] = !strpos($request['to'], '@') ? $request['to'] : '';
        $client = Client::where('phone',  $request['phone'])->where('user_id', $user_id)->firstOr(function () use ($request, $user_id) {
            return Client::create([
                'phone' =>  $request['phone'],
                'email' => $request['email'],
                'user_id' => $user_id,
                'uuid' => Str::uuid()
            ]);
        });
        return $client;
    }

    /**
     * campaignAdd
     *
     * @param  mixed $request
     * @return object App\Models\Campaign
     */
    private function campaignAdd($request)
    {
        return Campaign::create([
            'title'         => $request['title'],
            'channel'       => strtoupper($request['channel']),
            'provider'      => $request['provider'],
            'from'          => $request['from'],
            'to'            => $request['to'],
            'text'          => $request['text'],
            'is_otp'        => 0,
            'request_type'  => 'form',
            'status'        => 'starting',
            'way_type'      => $this->resource,
            'type'          => $request['type'],
            'template_id'   => $request['templateid'],
            'user_id'       => auth()->user()->id,
            'uuid'          => Str::uuid()
        ]);
    }

    /**
     * updatedChannel
     *
     * @return void
     */
    public function updatedChannel()
    {
        $this->reset('fromList');
        $this->reset('to');
        $this->reset('selectTo');
        $this->reset('selectedAudience');
        $this->fromList[1] = auth()->user()->phone_no;
        if ($this->channel == 'email') {
            $this->fromList[0] = 'noreply@hireach.archeeshop.com';
            $this->fromList[1] = auth()->user()->email;
            $this->from = 'noreply@hireach.archeeshop.com';
        } elseif (

            strpos(strtolower($this->channel), 'long_wa') !== false ||
            strpos(strtolower($this->channel), 'long_sms') !== false ||
            strtolower($this->channel) == 'sm' ||
            strtolower($this->channel) == 'pl' ||
            strtolower($this->channel) == 'waba' ||
            strtolower($this->channel) == 'webchat' ||
            strtolower($this->channel) == 'wc'
        ) {

            $this->fromList[0] = 'Auto';
            if (auth()->user()->phone_no) {
                $this->fromList[1] = auth()->user()->phone_no;
            }
            $this->from = 'Auto';
        }elseif(strtolower($this->channel) == 'sms'){
            $froms = explode(',', $this->providers->firstWhere('channel', 'SMS')->from);
            foreach($froms as $key => $from){
                $this->fromList[$key] = $from;
            }
        }
    }

    /**
     * render component
     *
     * @return
     */
    public function render()
    {
        $contacts = Client::orderBy('created_at', 'desc')->where('user_id', auth()->user()->currentTeam->user_id)->get();
        $audience = Audience::orderBy('created_at', 'desc')->where('user_id', auth()->user()->currentTeam->user_id)->get();
        $templates = Template::orderBy('created_at', 'desc')->where('user_id', auth()->user()->currentTeam->user_id)->where('resource', $this->resource)->get();

        return view('livewire.resource.send-resource', compact('contacts', 'audience', 'templates'));
    }
}
