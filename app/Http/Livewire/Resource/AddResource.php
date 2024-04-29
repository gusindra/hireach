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
    public $name;
    public $description;
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
    public $email;
    public $selectedContact;
    public $to;
    public $selectTo;
    public $selectedAudience;
    public $clients = [];








    public function mount($uuid)
    {
        $this->resource = $uuid;
        $this->template = Template::with('question')->where('uuid', $uuid)->first();
        $this->name = $this->template ? $this->template->name : '';
        $this->description = $this->template ? $this->template->description : '';
        $this->is_enabled = $this->template ? $this->template->is_enabled : '';
        $this->is_waiting = $this->template ? $this->template->is_wait_for_chat : '';
        $this->templateId = $this->template ? $this->template->id : '';
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'description' => 'required',
            'from' => 'required',
            'to' => 'required',
            'title' => 'required',
            'text' => 'required',
            'provider' => 'required'
        ];
    }

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
    public function updateTemplate()
    {
        // dd(1);
        $this->validate();
        Template::find($this->templateId)->update($this->modelData());
        $this->emit('saved');
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
        $from = 'ardana@gmail.com';
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
        $this->reset('to');
        $this->reset('selectTo');
        $this->reset('selectedAudience');
    }


    public function render()
    {

        $contacts = Client::orderBy('created_at', 'desc')->get();
        $audience = Audience::orderBy('created_at', 'desc')->get();



        return view('livewire.resource.send-resource', compact('contacts', 'audience'))
            ->layout('resource.show');
    }
}
