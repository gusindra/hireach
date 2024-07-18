<?php

namespace App\Http\Livewire\Setting;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Add extends Component
{
    public $key;
    public $value;
    public $remark;
    public $valueEdit;
    public $remarkEdit;
    public $showAddModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;

    // public $settings = [];
    public $selectedSettingId;

    public function showModalAdd()
    {
        $this->showAddModal = true;
    }

    public function save()
    {
        $this->validate([
            'key' => 'required',
            'value' => 'required',
            'remark' => 'nullable|string',
        ]);

        Setting::create([
            'key' => $this->key,
            'value' => $this->value,
            'remark' => $this->remark,
        ]);

        $this->reset(['key', 'value', 'remark']);
        $this->showAddModal = false;
        session()->flash('message', 'Setting added successfully.');
    }

    public function showModalUpdate($id)
    {
        $this->selectedSettingId = $id;
        $editable = Setting::findOrFail($this->selectedSettingId);
        $this->valueEdit = $editable->value;
        $this->remarkEdit = $editable->remark;

        $this->showEditModal = true;
    }

    public function updateSetting()
    {
        $this->validate([
            'valueEdit' => 'required',
            'remarkEdit' => 'nullable|string',
        ]);

        $setting = Setting::findOrFail($this->selectedSettingId);
        $setting->update([
            'value' => $this->valueEdit,
            'remark' => $this->remarkEdit,
        ]);

        $this->reset(['key', 'value', 'remark', 'selectedSettingId', 'showEditModal']);

        // CLEAR CACHE
        Cache::forget('vat_setting');
    }

    public function confirmDelete($id)
    {
        $this->selectedSettingId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        Setting::findOrFail($this->selectedSettingId)->delete();
        $this->showDeleteModal = false;
        $this->selectedSettingId = null;
        session()->flash('message', 'Setting deleted successfully.');

        //$this->loadSettings();
    }

        /**
     * readSetting
     *
     * @return void
     */
    private function readSetting()
    {
        return Setting::all();
    }

    public function render()
    {
        return view('livewire.setting.add', [
            'settings' => $this->readSetting(),
        ]);
    }
}
