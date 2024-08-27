<?php

namespace App\Http\Livewire\Contact;

use App\Models\ClientValidation;
use Livewire\Component;
use App\Models\Contact;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;

class ManageDuplicateContact extends Component
{
    public $duplicates = [];
    public $noDuplicatesMessage;

    public function mount()
    {
        $this->findDuplicates();


    }

    public function findDuplicates()
    {
        $phoneNumbers = Contact::select('phone_number')
            ->whereNotNull('phone_number')
            ->where('phone_number', '!=', '')
            ->groupBy('phone_number')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('phone_number');



        if ($phoneNumbers->isEmpty()) {
            $this->noDuplicatesMessage = 'Data tidak ada duplikasi.';
            $this->duplicates = [];
        } else {
            $this->duplicates = $phoneNumbers->mapWithKeys(function ($phoneNumber) {
                return [$phoneNumber => Contact::where('phone_number', $phoneNumber)->get()];
            });
            $this->noDuplicatesMessage = null;
        }
    }

    public function processDuplicates()
    {
        $this->duplicates = Arr::flatten($this->duplicates);
        $contacts = Contact::whereIn('phone_number', $this->duplicates)->get();

        $mostCompleteContact = null;
        $mostCompleteAttributeCount = 0;

        foreach ($contacts as $contact) {
            $attributeCount = 0;

            if ($contact->status_no !== null) $attributeCount++;
            if ($contact->status_wa !== null) $attributeCount++;
            if ($contact->activation_date !== null) $attributeCount++;
            if ($contact->file_name !== null) $attributeCount++;

            if ($attributeCount > $mostCompleteAttributeCount) {
                $mostCompleteAttributeCount = $attributeCount;
                $mostCompleteContact = $contact;
            }
        }

        if ($mostCompleteContact) {
            $deletedContactIds = Contact::whereIn('phone_number', $this->duplicates)
                ->where('id', '!=', $mostCompleteContact->id)
                ->pluck('id')
                ->toArray();

            Contact::whereIn('phone_number', $this->duplicates)
                ->where('id', '!=', $mostCompleteContact->id)
                ->delete();

            ClientValidation::whereIn('contact_id', $deletedContactIds)
                ->update(['contact_id' => $mostCompleteContact->id]);


        }

        session()->flash('message', 'Duplicate records processed successfully.');
        $this->findDuplicates(); // Refresh daftar duplikat jika diperlukan
    }
    private function calculateCompleteness(Contact $contact)
    {
        return collect([
            $contact->status_no,
            $contact->status_wa,
            $contact->activation_date,
            $contact->file_name
        ])->filter()->count();
    }

    private function isComplete(Contact $contact)
    {
        return !empty($contact->status_no) || !empty($contact->status_wa) || !empty($contact->activation_date) || !empty($contact->file_name);
    }

    public function render()
    {
        return view('livewire.contact.manage-duplicate-contact');
    }
}
