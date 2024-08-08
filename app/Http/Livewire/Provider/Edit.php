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
    public $status;
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
        $this->status = $this->provider->status;
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
        Provider::find($id)->update($this->modelData());
        $this->emit('saved');
    }

    /**
     * updateStatus
     *
     * @param  mixed $id
     * @return void
     */
    public function updateStatus($id)
    {
        $this->authorize('UPDATE_SETTING', 'SETTING');
        Provider::find($id)->update(['status'=>!$this->provider->status]);
        $this->provider->status = !$this->provider->status;
        $this->emit('updated');
        return redirect(request()->header('Referer'));
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
