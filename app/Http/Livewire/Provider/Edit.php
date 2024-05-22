<?php

namespace App\Http\Livewire\Provider;

use App\Models\Provider;
use Livewire\Component;

class Edit extends Component
{
    public $provider;
    public $name;
    public $code;
    public $uuid;
    public $modalDeleteVisible = false;
    public function mount($uuid)
    {
        $this->provider = Provider::find($uuid);
        $this->name = $this->provider->name;
        $this->code = $this->provider->code;
    }

    public function rules()
    {
        return [
            'code' => 'required',
            'name' => 'required',
        ];
    }

    public function modelData()
    {
        return [
            'name'                  => $this->name,
            'code'           => $this->code,
        ];
    }

    /**
     * Update Template
     *
     * @return void
     */
    public function update($id)
    {
        $this->validate();
        Provider::find($id)->update($this->modelData());
        $this->emit('saved');
    }

    public function actionShowDeleteModal()
    {
        $this->modalDeleteVisible = true;
    }
    public function delete()
    {
        if ($this->provider) {
            $this->provider->delete();
        }
        $this->modalDeleteVisible = false;
        return redirect()->route('admin.settings.provider');
    }



    public function render()
    {
        return view('livewire.provider.edit');
    }
}
