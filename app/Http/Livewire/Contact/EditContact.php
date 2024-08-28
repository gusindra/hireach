<?php

namespace App\Http\Livewire\Contact;

use Livewire\Component;
use App\Models\Contact;

class EditContact extends Component
{
    public $contact;
    public $no_ktp;
    public $status_wa;
    public $status_no;
    public $type;
    public $phone_number;
    public $file_name;
    public $activation_date;

    public function mount($contactId)
    {
        $this->contact = Contact::find($contactId);

        $this->no_ktp = $this->contact->no_ktp;
        $this->status_wa = $this->contact->status_wa;
        $this->status_no = $this->contact->status_no;
        $this->type = $this->contact->type;
        $this->phone_number = $this->contact->phone_number;
        $this->file_name = $this->contact->file_name;
        $this->activation_date = $this->contact->activation_date;
    }

    /**
     * save
     *
     * @return void
     */
    public function save()
    {
        $this->validate([
            'no_ktp' => 'required|string|max:255',
            'status_wa' => 'required|string|max:255',
            'status_no' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'file_name' => 'nullable|string|max:255',
            'activation_date' => 'nullable|date',
        ]);

        $this->contact->update([
            'no_ktp' => $this->no_ktp,
            'status_wa' => $this->status_wa,
            'status_no' => $this->status_no,
            'type' => $this->type,
            'phone_number' => $this->phone_number,
            'file_name' => $this->file_name,
            'activation_date' => $this->activation_date,
        ]);

        session()->flash('message', 'Contact updated successfully.');
        return redirect()->route('admin.contact');
    }

    public function render()
    {
        return view('livewire.contact.edit-contact');
    }
}
