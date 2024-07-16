<?php

namespace App\Http\Livewire\Setting;

use App\Models\Setting;
use Livewire\Component;

class Edit extends Component
{
    public $key;
    public $value;
    public $remark;
    public $showModal = false;
    public $selectedSettingId;

    protected $rules = [
        'value' => 'required|string',
        'remark' => 'nullable|string',
    ];

    public function mount($settingId)
    {
        $this->loadSetting($settingId);
    }

    public function loadSetting($settingId)
    {
        $setting = Setting::findOrFail($settingId);
        $this->selectedSettingId = $setting->id;
        $this->value = $setting->value;
        $this->remark = $setting->remark;
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate();

        $setting = Setting::findOrFail($this->selectedSettingId);
        $setting->update([
             'value' => $this->value,
            'remark' => $this->remark,
        ]);

        $this->reset(['key', 'value', 'remark', 'selectedSettingId', 'showModal']);
    }

    public function render()
    {
        return view('livewire.setting.edit');
    }
}
