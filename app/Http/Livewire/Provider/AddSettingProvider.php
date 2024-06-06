<?php

namespace App\Http\Livewire\Provider;

use App\Models\Provider;
use App\Models\SettingProvider;
use Livewire\Component;

class AddSettingProvider extends Component
{
    public $provider;
    public $providerId;
    public $key;
    public $value;
    public $input = [];
    public $array_data;
    public $modalActionVisible = false;
    public $confirmingActionRemoval = false;
    public $actionId;

    public function mount($provider)
    {
        $this->provider = $provider;
        $this->input['providerId'] = $provider->id;
        $this->array_data = Provider::all();
    }

    protected function rules()
    {
        return [
            'key' => 'required|string|max:255',
            'value' => 'required|string|max:255',
        ];
    }

    protected function messages()
    {
        return [
            'key.required' => 'The Key field is required.',
            'value.required' => 'The Value field is required.',
        ];
    }

    public function create()
    {
        $this->validate();

        $action = SettingProvider::firstOrCreate([
            'provider_id' => $this->provider->id,
            'key' => $this->key,
            'value' => $this->value,
        ]);

        $this->modalActionVisible = false;
        $this->resetForm();

        if ($action->wasRecentlyCreated) {
            $this->emit('added');
        } else {
            $this->emit('exist');
        }

        $this->emit('addArrayData', $action->id);
        $this->actionId = null;
    }

    public function delete()
    {
        $settingProvider = SettingProvider::findOrFail($this->actionId);
        $settingProvider->delete();

        $this->confirmingActionRemoval = false;

        $this->dispatchBrowserEvent('event-notification', [
            'eventName' => 'Deleted Provider',
            'eventMessage' => 'The provider has been deleted!',
        ]);
    }

    public function resetForm()
    {
        $this->key = '';
        $this->value = '';
    }

    public function actionShowModal()
    {
        $this->modalActionVisible = true;
        $this->resetForm();
    }

    public function updateShowModal($id)
    {
        $this->resetValidation();
        $this->resetForm();
        $this->actionId = $id;
        $this->modalActionVisible = true;
        $this->loadModel();
    }

    public function loadModel()
    {
        $data = SettingProvider::findOrFail($this->actionId);
        $this->key = $data->key;
        $this->value = $data->value;
    }

    public function deleteShowModal($id)
    {
        $this->actionId = $id;
        $this->confirmingActionRemoval = true;
    }

    public function render()
    {
        return view('livewire.provider.add-setting-provider', [
            'data' => SettingProvider::where('provider_id', $this->provider->id)->get(),
        ]);
    }
}
