<?php

namespace App\Http\Livewire\Resource;

use App\Jobs\ProcessEmailApi;
use App\Jobs\ProcessSmsApi;
use App\Jobs\ProcessWaApi;
use App\Models\Audience;
use App\Models\AudienceClient;
use App\Models\Client;
use App\Models\ProviderUser;
use Livewire\Component;
use App\Models\Template;
use Illuminate\Support\Facades\Auth;

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
    public $selectedContact;
    public $to;
    public $providers;
    public $selectTo;
    public $selectedAudience;
    public $modal;
    public $clients = [];
    public $fromList = [];
    public $modalActionVisible = false;

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
            'name'                  => $this->name,
            'description'           => $this->description,
            'is_enabled'            => $this->is_enabled,
            'is_wait_for_chat'      => $this->is_waiting,
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
            $this->text = $this->text . '<div class="bg-green-200 p-3 rounded-lg my-4">' . $action->message . '</div>';
        }
    }

    /**
     * sendResource
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
                $to = Client::whereIn('uuid', $clientIds)->pluck('email')->implode(',');
            } elseif ($this->channel == 'wa' || $this->channel == 'sm' || $this->channel == 'pl' || $this->channel == 'waba' || $this->channel == 'wc') {
                $to = Client::whereIn('uuid', $clientIds)->pluck('phone')->implode(',');
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
                    'channel' => $channel,
                    'type' => 0,
                    'title' => $title,
                    'text' => $action->message,
                    'templateid' => $templateid,
                    'to' => $to,
                    'from' => $from,
                    'provider' => $provider,
                    'otp' => checkContentOtp($action->message)
                ];
            }
        } else {
            $data = [
                'channel' => $channel,
                'type' => 0,
                'title' => $title,
                'text' => $text,
                'templateid' => $templateid,
                'to' => $to,
                'from' => $from,
                'provider' => $provider,
                'otp' => checkContentOtp($text)
            ];
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
            foreach ($contact as $p) {
                $data['to'] = $p;
                if ($template) {
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
     * @return json
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
                $this->to = Client::whereIn('uuid', $clientIds)->pluck('email')->implode(',');
            } elseif ($this->channel == 'wa' || $this->channel == 'sm' || $this->channel == 'pl') {
                $this->to = Client::whereIn('uuid', $clientIds)->pluck('phone')->implode(',');
            }
        } else {
            $this->clients = [];
        }
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
            strtolower($this->channel) == 'sm' ||
            strtolower($this->channel) == 'pl' ||
            strtolower($this->channel) == 'waba' ||
            strtolower($this->channel) == 'wc'
        ) {

            $this->fromList[0] = 'Auto';
            if (auth()->user()->phone_no) {
                $this->fromList[1] = auth()->user()->phone_no;
            }
            $this->from = 'Auto';
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
