<?php

namespace App\Http\Livewire\Audience;

use App\Models\AudienceClient;
use Livewire\Component;
use App\Models\Template;
use App\Models\Action;
use App\Models\Audience;
use App\Models\Client;
use App\Models\DataAction;

class AddContact extends Component
{
    public $audience;
    public $audienceId;
    public $actionId;
    public $contactId;
    public $is_multidata;
    public $array_data;
    public $modalActionVisible = false;
    public $confirmingActionRemoval = false;
    public $link_attachment;
    public $type;
    public $content = 'text';

    public function mount($audience)
    {
        $this->audience = $audience;
        $this->audienceId = $this->audience->id;
        $this->type = false;
        $this->array_data = Client::where('user_id', auth()->user()->currentTeam->user_id)->get();
    }



    public function modelData()
    {
        $data = [
            'client_id'    => $this->contactId,
            'audience_id'   => $this->audienceId
        ];
        return $data;
    }

    public function rules()
    {
        return [
            'contactId'   => 'required',
            'audienceId' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'contactId.required'   => 'The client field is required.',
            'audienceId.required' => 'The audience field is required.',
            'contactId.unique'   => 'The Clients  has already been taken.',
        ];
    }


    public function create()
    {
        // dd($this->modelData());
        $this->validate();
        $action = AudienceClient::firstOrCreate($this->modelData(), $this->modelData());
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
        $audienceClient = AudienceClient::findOrFail($this->actionId);
        $audienceClient->delete();
        $this->confirmingActionRemoval = false;

        $this->dispatchBrowserEvent('event-notification', [
            'eventName' => 'Deleted Page',
            'eventMessage' => 'The page (' . $this->actionId . ') has been deleted!',
        ]);
    }


    public function resetForm()
    {
        $this->contactId = null;
    }


    public function actionShowModal()
    {
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
        return AudienceClient::where('audience_id', $this->audienceId)->get();
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
        $data = AudienceClient::find($this->actionId);
        $this->contactId    = $data->contact_id;
    }

    public function deleteShowModal($id)
    {
        $this->actionId = $id;
        $data = AudienceClient::find($this->actionId);
        $this->contactId = $data->contact_id;
        $this->confirmingActionRemoval = true;
    }

    public function render()
    {
        return view('livewire.audience.add-action', [
            'data' => $this->read(),
        ]);
    }
}
