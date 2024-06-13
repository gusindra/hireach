<?php

namespace App\Http\Livewire\Audience;

use App\Exports\ExportAudienceContact;
use App\Models\AudienceClient;
use Livewire\Component;
use App\Models\Client;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportContact;

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

    /**
     * mount
     *
     * @param  mixed $audience
     * @return void
     */
    public function mount($audience)
    {
        $this->audience = $audience;
        $this->audienceId = $this->audience->id;
        $this->type = false;
    }

    /**
     * modelData
     *
     * @return void
     */
    public function modelData()
    {
        $data = [
            'client_id'    => $this->contactId,
            'audience_id'   => $this->audienceId
        ];
        return $data;
    }

    /**
     * rules
     *
     * @return void
     */
    public function rules()
    {
        return [
            'contactId'   => 'required',
            'audienceId' => 'required',
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
            'contactId.required'   => 'The client field is required.',
            'audienceId.required' => 'The audience field is required.',
            'contactId.unique'   => 'The Clients  has already been taken.',
        ];
    }

    /**
     * create
     *
     * @return void
     */
    public function create()
    {
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

    /**
     * resetForm
     *
     * @return void
     */
    public function resetForm()
    {
        $this->contactId = null;
    }

    /**
     * actionShowModal
     *
     * @return void
     */
    public function actionShowModal()
    {
        $this->array_data = Client::where('user_id', auth()->user()->currentTeam->user_id)->get();
        $this->modalActionVisible = true;
        $this->resetForm();
        $this->actionId = null;
    }

    /**
     * exportContact
     *
     * @return void
     */
    public function exportContact()
    {
        Excel::store(new ExportAudienceContact($this->audience->id), $this->audience->id.'_client.xlsx');
        return Excel::download(new ExportAudienceContact($this->audience->id), $this->audience->name.'_client.xlsx');
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

    /**
     * deleteShowModal
     *
     * @param  mixed $id
     * @return void
     */
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
