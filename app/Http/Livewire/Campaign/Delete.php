<?php

namespace App\Http\Livewire\Campaign;

use Livewire\Component;
use App\Models\Campaign;
use App\Models\CampaignSchedule; // Import CampaignSchedule model

class Delete extends Component
{
    public $campaign;
    public $showModal = false;

    public function mount($campaignId)
    {
        $this->campaign = Campaign::findOrFail($campaignId);
    }

    public function delete()
    {
        CampaignSchedule::where('campaign_id', $this->campaign->id)->delete();
        $this->campaign->delete();

        return redirect()->route('campaign.index'); // Redirect to campaign index or another page
    }

    public function render()
    {
        return view('livewire.campaign.delete');
    }
}
