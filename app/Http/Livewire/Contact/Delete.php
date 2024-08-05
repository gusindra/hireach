<?php

namespace App\Http\Livewire\Contact;

use Livewire\Component;
use App\Models\Client;

class Delete extends Component
{
    public $modalDeleteVisible = false;
    public $contactId;
    public $contact;

    protected $listeners = ['confirmDelete'];

    public function confirmDelete($id)
    {
        $this->modalDeleteVisible = true;
        $this->contactId = $id;
        $this->contact = Client::find($id);
    }

    public function render()
    {
        return view('livewire.contact.delete', [
            'contact' => $this->contact
        ]);
    }

    public function delete()
    {
        if ($this->contact) {
            $this->contact->delete();
        }
        $this->modalDeleteVisible = false;
        return redirect()->route('contact.index')->with('message', 'Contact deleted successfully.');
    }
}
