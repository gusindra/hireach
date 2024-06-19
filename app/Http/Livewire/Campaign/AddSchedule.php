<?php

namespace App\Http\Livewire\Campaign;

use App\Models\Campaign;
use App\Models\CampaignSchedule;
use Livewire\Component;

class AddSchedule extends Component
{
    public $campaign_id;
    public $days = [
        'sunday' => false,
        'monday' => false,
        'tuesday' => false,
        'wednesday' => false,
        'thursday' => false,
        'friday' => false,
        'saturday' => false,
    ];

    public $times = [
        'sunday' => '',
        'monday' => '',
        'tuesday' => '',
        'wednesday' => '',
        'thursday' => '',
        'friday' => '',
        'saturday' => '',
    ];

    public function mount($campaign_id)
    {
        $this->campaign_id = $campaign_id;
        $this->loadExistingSchedules();
    }

    public function getCampaign()
    {
        $campaign = Campaign::find($this->campaign_id);
        return $campaign;
    }

    public function render()
    {

        return view('livewire.campaign.add-schedule', ['campaign' => $this->getCampaign()]);
    }

    public function loadExistingSchedules()
    {
        $existingSchedules = CampaignSchedule::where('campaign_id', $this->campaign_id)->get();

        foreach ($existingSchedules as $schedule) {
            $day = strtolower($schedule->day);
            $this->days[$day] = true;
            $this->times[$day] = $schedule->time;
        }
    }


    public function generateSchedule()
    {
        foreach ($this->days as $day => $selected) {
            if ($selected && !empty($this->times[$day])) {
                // Update or create schedule
                CampaignSchedule::updateOrCreate(
                    [
                        'campaign_id' => $this->campaign_id,
                        'day' => ucfirst($day),
                    ],
                    [
                        'time' => $this->times[$day],
                    ]
                );
            } else {
                // If unchecked and exists, delete the schedule
                CampaignSchedule::where('campaign_id', $this->campaign_id)
                    ->where('day', ucfirst($day))
                    ->delete();
            }
        }

        session()->flash('message', 'Schedule generated successfully.');
        $this->resetForm();
        $this->loadExistingSchedules();
    }

    private function resetForm()
    {
        $this->days = array_fill_keys(array_keys($this->days), false);
        $this->times = array_fill_keys(array_keys($this->times), '');
    }
}
