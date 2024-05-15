<?php

namespace App\Http\Livewire\User;

use App\Models\Provider;
use App\Models\ProviderUser;
use Livewire\Component;

class AddProvider extends Component


{
    public $user;
    public $userId;
    public $actionId;
    public $providerId;
    public $is_multidata;
    public $array_data;
    public $modalActionVisible = false;
    public $confirmingActionRemoval = false;
    public $link_attachment;
    public $type;
    public $content = 'text';

    public function mount($user)
    {
        $this->user = $user;
        $this->userId = $this->user->id;
    }



    public function modelData()
    {

        $data = [
            'provider_id'    => $this->providerId,
            'user_id'   => $this->userId
        ];

        return $data;
    }

    public function rules()
    {
        return [
            'providerId'   => 'required',
            'userId' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'providerId.required'   => 'The client field is required.',
            'userId.required' => 'The user field is required.',
            'providerId.unique'   => 'The Clients  has already been taken.',
        ];
    }


    public function create()
    {
        // dd($this->modelData());
        // $this->validate();
        $action = ProviderUser::firstOrCreate($this->modelData(), $this->modelData());
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


    public function resetForm()
    {
        $this->providerId = null;
    }


    public function actionShowModal()
    {
        $this->array_data = Provider::all();
        $this->modalActionVisible = true;
        $this->resetForm();
        $this->actionId = null;
    }

    /**
     * The read function.
     *
     * @return void
     */
    public function read()
    {
        $provider = ProviderUser::where('user_id', $this->userId)->get();
        return $provider;
    }

    public function updateShowModal($id)
    {
        $this->resetValidation();
        $this->resetForm();
        $this->actionId = $id;
        $this->modalActionVisible = true;
        $this->loadModel();
    }

    /**
     * Loads the model data
     * of this component.
     *
     * @return void
     */
    public function loadModel()
    {
        $data = ProviderUser::find($this->actionId);
        dd($data);
        $this->providerId    = $data->provider_id;
    }

    public function deleteShowModal($id)
    {
        $this->actionId = $id;
        $data = ProviderUser::find($this->actionId);
        $this->providerId = $data->provider_id;
        $this->confirmingActionRemoval = true;
    }


    public function render()
    {

        return view('livewire.user.add-provider', [
            'data' => $this->read(),
        ]);
    }
}
