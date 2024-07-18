<?php

namespace App\Http\Livewire\User;

use App\Models\Provider;
use App\Models\ProviderUser;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class AddProvider extends Component


{
    public $user;
    public $userId;
    public $actionId;
    public $channel;
    public $provider_id;
    public $is_multidata;
    public $array_data;
    public $providers;
    public $provider = [];
    public $channels = [];
    public $modalActionVisible = false;
    public $confirmingActionRemoval = false;
    public $input = [
        'provider_id' => '',
        'channel' => '',
        'from' => ''
    ];

    /**
     * mount
     *
     * @param  mixed $user
     * @return void
     */
    public function mount($user)
    {

        $this->provider_id = '';
        $this->user = $user;
        // $this->provider = ProviderUser::where('user_id', $user->id)->get();

        $this->userId = $this->user->id;
    }

    /**
     * modelData
     *
     * @return void
     */
    public function modelData()
    {
        $data = [
            'provider_id'   => $this->provider_id,
            'channel'       => $this->channel,
            'from'          => $this->from,
            'user_id'       => $this->userId
        ];

        return $data;
    }


    /**
     * updatedinputproviderid
     *
     * @param  mixed $value
     * @return void
     */
    public function updatedinputproviderid($value)
    {
        $provider = Provider::find($value);

        if ($provider && !empty($provider->channel)) {
            $channelsString = $provider->channel;

            $this->channels = explode(',', $channelsString);
        } else {
            $this->channels = [];
        }
    }

    /**
     * rules
     *
     * @return void
     */
    public function rules()
    {
        return [
            'input.provider_id' => 'required',
            'channel'           => 'required',
            'userId'            => 'required',
        ];
    }

    /**
     * messages
     *
     * @return void
     */
    public function messages()
    {
        return [
            'provider_id.required'  => 'The Provider field is required.',
            'channel.required'      => 'The Channel field is required.',
            'userId.required'       => 'The user field is required.',
            'provider_id.unique'    => 'The Provider has already been taken.',
        ];
    }

    /**
     * create
     *
     * @return void
     */
    public function create()
    {
        $action = ProviderUser::firstOrCreate($this->modelData(), $this->modelData());
        $this->modalActionVisible = false;
        $this->resetForm();
        if ($action->wasRecentlyCreated) {
            $this->emit('added');
            Cache::forget('provider-user-'.$this->userId);
        } else {
            $this->emit('exist');
        }

        $this->emit('addArrayData', $action->id);
        $this->actionId = null;
    }


    /**
     * addProvider
     *
     * @return void
     */
    public function addProvider()
    {
        $action = ProviderUser::firstOrCreate([
            'provider_id'   => $this->input['provider_id'],
            'channel'       => strtoupper($this->input['channel']),
            'from'          => strtoupper($this->input['from']),
            'user_id'       => $this->userId
        ]);

        $this->modalActionVisible = false;
        $this->resetForm();
        if ($action->wasRecentlyCreated) {
            $this->emit('added');
            Cache::forget('provider-user-'.$this->userId);
        } else {
            $this->emit('exist');
        }

        $this->emit('addArrayData', $action->id);
        $this->actionId = null;
    }

    /**
     * dehydrate
     *
     * @return void
     */
    public function dehydrate()
    {
        if (!$this->modalActionVisible) {
            $this->resetForm();
        }
    }

    /**
     * The delete function.
     *
     * @return void
     */
    public function delete()
    {
        $userClient = ProviderUser::findOrFail($this->actionId);
        $userClient->delete();
        $this->confirmingActionRemoval = false;

        $this->dispatchBrowserEvent('event-notification', [
            'eventName' => 'Deleted Page',
            'eventMessage' => 'The page (' . $this->actionId . ') has been deleted!',
        ]);
    }

    /**
     * resetForm
     *
     * @return void
     */
    public function resetForm()
    {
        $this->provider_id = null;
    }

    /**
     * actionShowModal
     *
     * @return void
     */
    public function actionShowModal()
    {
        $this->array_data = Provider::all();
        $this->modalActionVisible = true;
        $this->resetForm();
        $this->actionId = null;
    }

    /**
     * The read provider function.
     *
     * @return object
     */
    public function read()
    {

        $provider = ProviderUser::where('user_id', $this->userId)->get();
        return $provider;
    }


    /**
     * updateShowModal
     *
     * @param  mixed $id
     * @return void
     */
    public function updateShowModal($id)
    {
        $this->resetValidation();
        $this->resetForm();
        $this->actionId = $id;
        $this->modalActionVisible = true;
        $this->loadModel();
    }

    /**
     * Loads the provider user data
     * of this component.
     *
     * @return void
     */
    public function loadModel()
    {
        $data = ProviderUser::find($this->actionId);
        $this->provider_id = $data->provider_id;
    }

    /**
     * deleteShowModal
     *
     * @param  mixed $id
     * @return void
     */
    public function deleteShowModal($id)
    {
        $this->actionId = $id;
        $data = ProviderUser::find($this->actionId);
        $this->provider_id = $data->provider_id;
        $this->confirmingActionRemoval = true;
    }

    /**
     * render
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.user.add-provider', [
            'data' => $this->read(),
        ]);
    }
}
