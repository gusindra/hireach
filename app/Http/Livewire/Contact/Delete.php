<?php

namespace App\Http\Livewire\Contact;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use App\Models\Client;

class Delete extends Component
{
    use AuthorizesRequests;
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
        $this->authorize('DELETE_RESOURCE_USR', $this->contact->user_id);
        if ($this->contact) {
            $this->contact->delete();
        }
        $this->modalDeleteVisible = false;
        return redirect()->route('contact.index')->with('message', 'Contact deleted successfully.');
    }
}
