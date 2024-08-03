<?php

namespace App\Http\Livewire\Campaign;

use App\Models\Campaign;
use App\Models\CampaignSchedule;
use Livewire\Component;

class AddSchedule extends Component
{
    public $campaign;
    public $campaign_id;
    public $typeShedule;
    public $maxDateDay = 31;
    public $dateTime;
    public $dateDay;
    public $typeDay = 'name';
    public $month = 1;
    public $typeLoop;
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

    /**
     * mount
     *
     * @param  mixed $campaign_id
     * @return void
     */
    public function mount($campaign)
    {
        $this->campaign = $campaign;
        $this->campaign_id = $campaign->id;
        $this->typeShedule = $campaign->shedule_type;
        $this->typeLoop = $campaign->loop_type;
        $this->loadExistingSchedules();
    }

    /**
     * render
     *
     * @return void
     */
    public function render()
    {
        // $this->authorize('VIEW_RESOURCE_USR', $this->campaign->user_id);

        return view('livewire.campaign.add-schedule', ['campaign' => $this->getCampaign(), 'schedule' => $this->getSchedule()]);
    }

    /**
     * getCampaign
     *
     * @return void
     */
    public function getCampaign()
    {
        return $this->campaign;
    }

    /**
     * getCampaign
     *
     * @return void
     */
    public function getSchedule()
    {
        return CampaignSchedule::where('campaign_id', $this->campaign_id)->get();
    }

    /**
     * loadExistingSchedules
     *
     * @return void
     */
    public function loadExistingSchedules()
    {
        $existingSchedules = CampaignSchedule::where('campaign_id', $this->campaign_id)->get();

        foreach ($existingSchedules as $schedule) {
            $day = strtolower($schedule->day);
            $this->days[$day] = true;
            $this->times[$day] = $schedule->time;
        }
    }


    /**
     * generateSchedule
     *
     * @return void
     */
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

        Campaign::find($this->campaign_id)->update([
            'loop_type'     => $this->typeLoop,
            'shedule_type'  => $this->typeShedule
        ]);

        session()->flash('message', 'Schedule generated successfully.');
        $this->resetForm();
        $this->loadExistingSchedules();
    }

    /**
     * addSchedule
     *
     * @return void
     */
    public function addSchedule(){
        if($this->typeShedule=='daily'){
            $this->month = "0";
            $this->dateDay = "0";
        }elseif($this->typeShedule=='monthly'){
            $this->month = "0";
        }
        $this->validate([
            'dateDay' => 'required',
            'dateTime' => 'required',
            'month' => 'required',
        ]);
        CampaignSchedule::updateOrCreate(
            [
                'campaign_id' => $this->campaign_id,
                'day' => ucfirst($this->dateDay),
                'month' => ucfirst($this->month),
            ],
            [
                'time' => $this->dateTime,
            ]
        );
        $this->loadExistingSchedules();
        $this->emit('refreshLivewireDatatable');
    }

    /**
     * resetForm
     *
     * @return void
     */
    private function resetForm()
    {
        $this->days = array_fill_keys(array_keys($this->days), false);
        $this->times = array_fill_keys(array_keys($this->times), '');
    }

    /**
     * updatedAudienceId
     *
     * @param  mixed $value
     * @return void
     */
    public function updatedMonth($value)
    {
        $this->month = $value;
        $year = date("2024");
        $month = date($value);
        $this->maxDateDay = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    }

    /**
     * deleteSchedule
     *
     * @param  mixed $value
     * @return void
     */
    public function deleteSchedule($value){
        // dd($value);
        $data = CampaignSchedule::find($value);
        if($data){
            // dd($data);
            $data->delete();
            $this->emit('deleted');
        }
        $this->emit('fail_delete');

    }

    /**
     * updatedAudienceId
     *
     * @param  mixed $value
     * @return void
     */
    public function updatedDateDay($value)
    {
        if(is_numeric($value) && $value > $this->maxDateDay){
            $this->dateDay = $this->maxDateDay;
            $this->emit('invalid_day');
        }elseif(!is_numeric($value)){
            $this->dateDay = $value;
        }else{
            $this->emit('valid_day');
        }
    }
}
