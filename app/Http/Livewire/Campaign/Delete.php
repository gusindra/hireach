<?php

namespace App\Http\Livewire\Campaign;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use App\Models\Campaign;
use App\Models\CampaignSchedule; // Import CampaignSchedule model

class Delete extends Component
{
    use AuthorizesRequests;
    public $campaign;
    public $showModal = false;

    public function mount($campaignId)
    {
        $this->campaign = Campaign::findOrFail($campaignId);
        $this->authorize('VIEW_CAMPAIGN', $this->campaign->user_id);
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
