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
        // Ambil semua data kontak
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
                $this->addDataNoHp($contact->phone_number);
            }
        }

        $this->hideModal();
    }

    public function addAllClientIds()
    {
        foreach ($this->contacts as $contact) {
            if (!empty($contact->phone_number)) {
                $this->addClientId($contact->phone_number);
            }
        }

        $this->hideModal();
    }

    public function performAllActions()
    {
        foreach ($this->contacts as $contact) {
            if (!empty($contact->phone_number)) {
                $this->addDataNoHp($contact->phone_number);
                $this->addClientId($contact->phone_number);
            }
        }

        $this->hideModal();
    }

    public function addDataNoHp($phoneNumber)
    {

        $contact = Contact::where('phone_number', $phoneNumber)->first();
        if ($contact) {

            Client::updateOrCreate(
                ['phone' => $contact->phone_number],
                [
                    'uuid' => (string) Str::uuid(),
                    'phone' => $contact->phone_number,
                    'name' => $contact->file_name,
                    'user_id' => auth()->user()->id,

                ]
            );
        }
    }

    public function addClientId($phoneNumber)
    {
        $contact = Contact::where('phone_number', $phoneNumber)->first();
        $client = Client::where('phone', $phoneNumber)->first();

        if ($contact && $client) {
            ClientValidation::updateOrCreate(
                ['contact_id' => $contact->id, 'client_id' => $client->id],
                ['user_id' => auth()->id()]
            );
        }
    }
}
