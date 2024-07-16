<?php

namespace App\Http\Livewire\Setting;

use App\Models\Setting;
use Livewire\Component;

class Add extends Component
{
    public $key;
    public $value;
    public $remark;
    public $showModal = false;
    public $showDeleteModal = false;
    public $settings = [];
    public $selectedSettingId;

    protected $rules = [
        'key' => 'required|string',
        'value' => 'required|string',
        'remark' => 'nullable|string',
    ];

    public function mount()
    {
        $this->loadSettings();
    }

    public function loadSettings()
    {
        $this->settings = Setting::all();
    }

    public function save()
    {
        $this->validate();

        Setting::create([
            'key' => $this->key,
            'value' => $this->value,
            'remark' => $this->remark,
        ]);

        $this->reset(['key', 'value', 'remark']);
        $this->showModal = false;
        session()->flash('message', 'Setting added successfully.');

        $this->loadSettings();
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

        $this->loadSettings();
    }
    public function render()
    {
        return view('livewire.setting.add');
    }
}
