<?php

namespace App\Http\Livewire\Campaign;

use App\Models\Audience;
use App\Models\Campaign;
use App\Models\CampaignSchedule;
use App\Models\ProviderUser;
use App\Models\Template;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

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
    public $selectTo = 'manual';
    public $userProvider;
    public $selectedProviderCode;
    public $templates;
    public $template_id;
    public $formName;
    public $hasSchedule = false;





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
        $this->selectTo = $campaign->audience_id ? 'audience' : 'manual';

        $this->audience = Audience::withCount('audienceClients')->get();

        $this->userProvider = ProviderUser::with('provider')
            ->where('user_id', Auth::id())
            ->get();

        $this->userProvider->firstWhere('provider.code', $this->provider);

        $this->selectedProviderCode = $this->provider;

        $this->templates = Template::with('question')->find(auth()->user()->id)->get();

        $this->hasSchedule = CampaignSchedule::where('campaign_id', $this->campaign_id)->exists();
    }

    public function checkSchedule()
    {
        $this->hasSchedule = CampaignSchedule::where('campaign_id', $this->campaign_id)->exists();
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

        if (!$this->hasSchedule) {
            session()->flash('error', 'Campaign must have at least one schedule.');
            return;
        }

        $this->campaign->status = 'started';
        $this->campaign->save();
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
            $this->emit('savedFroTo');
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
            $this->text = $this->text . '<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 my-4 rounded-lg shadow-md">
                <p class="font-semibold">' . $action->message . '</p>
            </div>';
        }
    }



    public function updatedProvider($providerCode)
    {
        $selectedProvider = $this->userProvider->firstWhere('provider.code', $providerCode);
        $this->channel = $selectedProvider ? $selectedProvider->channel : '';
    }

    public function read()
    {
        return CampaignSchedule::where('campaign_id', $this->campaign_id)->exists();
    }

    public function render()
    {

        return view('livewire.campaign.edit', ['hasSchedule' => $this->read()]);
    }
}
