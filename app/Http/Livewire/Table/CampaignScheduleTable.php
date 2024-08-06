<?php

namespace App\Http\Livewire\Table;

use App\Models\CampaignSchedule;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;

class CampaignScheduleTable extends LivewireDatatable
{
    public $model = CampaignSchedule::class;
    public $campaignId;
    public $canEdit = true;
    public $typeShedule;

    public function builder()
    {
        return CampaignSchedule::query()->where('campaign_id', '=', $this->campaignId);
    }

    public function columns()
    {
        $data = [
            BooleanColumn::name('status')->label('Status'),
            Column::callback(['month','day'], function ($month, $day) {
                $text = "Every <b>". (!is_numeric($day) ? '  '.ucfirst($day) : ($day<4 ? ($day==1 ? $day.'st':($day==2 ? $day.'nd':($day==1 ? $day.'rd':''))) : $day.'th'))."</b>";
                $text = $text. ($this->typeShedule == 'yearly' ? ' of '. date('F', mktime(0, 0, 0, (int)$month)) : ($this->typeShedule == 'daily'?' Day':' of Month '));
                return $text;
            })->label('Schedule'),
            Column::name('time')->label('Exe Time')->editable($this->canEdit),
            DateColumn::name('updated_at')->format('d M Y H:i:s')->editable($this->canEdit)->label('Updated Date'),
        ];
        if($this->canEdit){
            $data = [
                BooleanColumn::name('status')->label('Status'),
                Column::callback(['month','day'], function ($month, $day) {
                    $text = "Every <b>". (!is_numeric($day) ? '  '.ucfirst($day) : ($day<4 ? ($day==1 ? $day.'st':($day==2 ? $day.'nd':($day==1 ? $day.'rd':''))) : $day.'th'))."</b>";
                    $text = $text. ($this->typeShedule == 'yearly' ? ' of '. date('F', mktime(0, 0, 0, $month)) : ($this->typeShedule == 'daily'?' Day':' of Month '));
                    return $text;
                })->label('Schedule'),
                Column::name('month')->label('Exe Month')->editable($this->canEdit),
                Column::name('day')->label('Exe Day')->editable($this->canEdit),
                Column::name('time')->label('Exe Time')->editable($this->canEdit),
                DateColumn::name('updated_at')->format('d M Y H:i:s')->editable($this->canEdit)->label('Updated Date'),
                Column::name('delete')->delete()
            ];
        }
        return $data;
    }

    public function deleteQuery($id)
    {
        CampaignSchedule::destroy($id);

        $this->emit('updateSavedQueries', $this->getSavedQueries());
    }

    public function getSavedQueries()
    {
        return CampaignSchedule::query()->where('campaign_id', '=', $this->campaignId);;
    }
}
