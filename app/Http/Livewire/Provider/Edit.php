<?php

namespace App\Http\Livewire\Provider;

use App\Models\Provider;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Edit extends Component
{
    use AuthorizesRequests;
    public $provider;
    public $name;
    public $company;
    public $code;
    public $channel;
    public $uuid;
    public $modalDeleteVisible = false;

    /**
     * mount
     *
     * @param  mixed $uuid
     * @return void
     */
    public function mount($uuid)
    {

        $this->provider = Provider::find($uuid);
        $this->name = $this->provider->name;
        $this->code = $this->provider->code;
        $this->company = $this->provider->company;
        $this->channel = $this->provider->channel;
    }

    /**
     * rules
     *
     * @return void
     */
    public function rules()
    {
        return [
            'code' => 'required',
            'name' => 'required',
            'company' => 'string',
            'channel' => 'required'
        ];
    }

    /**
     * modelData
     *
     * @return void
     */
    public function modelData()
    {
        return [
            'name' => $this->name,
            'code' => $this->code,
            'company' => $this->company,
            'channel' => $this->channel
        ];
    }


    /**
     * update
     *
     * @param  mixed $id
     * @return void
     */
    public function update($id)
    {
        $this->authorize('UPDATE_SETTING', 'SETTING');
        $this->validate();
        $old = Provider::find($id);

        Provider::find($id)->update($this->modelData());
        addLog(Provider::find($id), $old);
        $this->emit('saved');
    }

    /**
     * actionShowDeleteModal
     *
     * @return void
     */
    public function actionShowDeleteModal()
    {
        $this->modalDeleteVisible = true;
    }

    /**
     * delete
     *
     * @return void
     */
    public function delete()
    {
        $this->authorize('DELETE_SETTING', 'SETTING');
        if ($this->provider) {
            $this->provider->delete();
            addLog(null, $this->provider);
        }
        $this->modalDeleteVisible = false;
        return redirect()->route('admin.settings.provider');
    }


    /**
     * render
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.provider.edit');
    }
}
