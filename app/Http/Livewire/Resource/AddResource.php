<?php

namespace App\Http\Livewire\Resource;

use App\Models\Audience;
use App\Models\AudienceClient;
use App\Models\Client;
use Livewire\Component;
use App\Models\Template;

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
    public $fromList = [];
    public $type;
    public $otp;
    public $email;
    public $selectedContact;
    public $to;
    public $selectTo;
    public $selectedAudience;
    public $clients = [];

    /**
     * mount
     *
     * @param  mixed $uuid
     * @return void
     */
    public function mount($uuid)
    {
        $this->resource = $uuid;
        $this->template = Template::with('question')->where('uuid', $uuid)->first();
        $this->channel = $this->channel ? $this->channel : '';
        $this->is_enabled = $this->template ? $this->template->is_enabled : '';
        $this->is_waiting = $this->template ? $this->template->is_wait_for_chat : '';
        $this->templateId = $this->template ? $this->template->id : '';
        $this->from = auth()->user()->email;
        $this->templateId =  '0';
        $this->selectTo = 'manual';
        $this->otp;
        if($this->resource == 2){
            $this->bound = 'out';
        }
    }

    /**
     * rules
     *
     * @return void
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
     * @return void
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
     * Update Template
     *
     * @return void
     */
    public function updateTemplate($value)
    {
        // dd(1);
        $this->validate();
        Template::find($this->templateId)->update($this->modelData());
        $this->emit('saved');
    }

    public function updatedTemplateId($value)
    {
        $this->text = '';
        $this->templateId = $value;
        $template = Template::with('actions')->find($value);
        foreach($template->actions as $action){
            $this->text = $this->text.'<div class="bg-green-200 p-3 rounded-lg my-4">'.$action->message.'</div>';
        }
    }

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

        $channel = $this->channel;
        $type = $this->type;
        $title = $this->title;
        $text = $this->text;
        $templateid = $this->templateId;
        $from = $this->from;
        $provider = $this->provider;
        $otp = $this->is_enabled;

        $data = [
            'channel' => $channel,
            'type' => $type,
            'title' => $title,
            'text' => $text,
            'templateid' => $templateid,
            'to' => $to,
            'from' => $from,
            'provider' => $provider,
            'otp' => $otp,
        ];

        dd($data);
    }

    public function updatedSelectTo()
    {
        $this->reset('to');
    }
    public function updatedSelectedContact()
    {
        $this->to = $this->selectedContact;
    }

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


    public function updatedChannel()
    {
        $this->reset('fromList');
        $this->reset('to');
        $this->reset('selectTo');
        $this->reset('selectedAudience');
        if ($this->channel == 'email') {
            $this->fromList[0] = 'noreply@hireach.archeeshop.com';
            $this->fromList[1] = auth()->user()->email;
            $this->from = 'noreply@hireach.archeeshop.com';
        } elseif ($this->channel == 'wa' || $this->channel == 'sm' || $this->channel == 'pl' || $this->channel == 'waba' || $this->channel == 'wc') {
            $this->fromList[0] = 'Auto';
            if(auth()->user()->phone_no)
                $this->fromList[1] = auth()->user()->phone_no;
            $this->from = 'Auto';
        }
    }


    public function render()
    {

        $contacts = Client::orderBy('created_at', 'desc')->where('user_id', auth()->user()->currentTeam->user_id)->get();
        $audience = Audience::orderBy('created_at', 'desc')->where('user_id', auth()->user()->currentTeam->user_id)->get();
        $templates = Template::orderBy('created_at', 'desc')->where('user_id', auth()->user()->currentTeam->user_id)->where('resource', $this->resource)->get();

        return view('livewire.resource.send-resource', compact('contacts', 'audience', 'templates'));
    }
}
