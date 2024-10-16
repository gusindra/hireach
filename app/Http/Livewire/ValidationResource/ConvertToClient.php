<?php

namespace App\Http\Livewire\ValidationResource;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Client;
use App\Models\Contact;
use App\Models\ClientValidation;

class ConvertToClient extends Component
{
    public $showModal = false;
    public $contacts = [];

    public function render()
    {
        // Retrieve all contact data
        $this->contacts = Contact::all();
        return view('livewire.validation-resource.convert-to-client');
    }

    public function showModal()
    {
        $this->showModal = true;
    }

    public function hideModal()
    {
        $this->showModal = false;
    }

    public function addAllDataNoHp()
    {
        foreach ($this->contacts as $contact) {
            if (!empty($contact->phone_number)) {
                $this->addDataNoHp($contact);
                if ($this->isValidContact($contact)) {
                    $this->addClientId($contact, false);
                }
            }
        }

        $this->hideModal();
    }

    public function addAllClientIds()
    {
        foreach ($this->contacts as $contact) {
            if ($this->isValidContact($contact)) {
                $this->addClientId($contact);
            }
        }

        $this->hideModal();
    }

    public function performAllActions()
    {
        foreach ($this->contacts as $contact) {
            if (!empty($contact->phone_number)) {
                $this->addDataNoHp($contact);
                $this->addClientId($contact, false);
            }
        }

        $this->hideModal();
    }

    /**
     * addDataNoHp
     *
     * @param  mixed $contact
     * @return void
     */
    protected function addDataNoHp(Contact $contact)
    {

        $client = Client::updateOrCreate(
            ['phone' => $contact->phone_number],
            [
                'uuid' => (string) Str::uuid(),
                'phone' => $contact->phone_number,
                'user_id' => auth()->user()->id,
            ]
        );

        if ($this->isValidContact($contact)) {
            $this->addClientId($contact, false);
        }
    }

    /**
     * addClientId
     *
     * @param  mixed $contact
     * @param  mixed $withValidation
     * @return void
     */
    protected function addClientId(Contact $contact, $withValidation = true)
    {
        $client = Client::where('phone', $contact->phone_number)
                        ->where('user_id', auth()->id())
                        ->first();

        if ($client) {
            if (!$withValidation || $this->isValidContact($contact)) {
                ClientValidation::updateOrCreate(
                    ['contact_id' => $contact->id, 'user_id' => $client->user_id],
                    ['client_id' => $client->id]
                );
            }
        }
    }

    /**
     * isValidContact
     *
     * @param  mixed $contact
     * @return mixed
     */
    protected function isValidContact(Contact $contact)
    {
        return !empty($contact->status_no) || !empty($contact->status_wa) || !empty($contact->activation_date);
    }
}
