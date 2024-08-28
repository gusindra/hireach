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

    public function processDuplicates($key)
    {
        // $this->duplicates = Arr::flatten($this->duplicates);
        $contacts = Contact::where('phone_number', $key)->get();
        // $contacts = Contact::whereIn('phone_number', $this->duplicates->keys())->get();
        $mostCompleteContact = null;
        $mostCompleteAttributeCount = 0;

        foreach ($contacts as $contact) {
            $attributeCount = 0;

            if ($contact->status_no !== null) $attributeCount++;
            if ($contact->status_wa !== null) $attributeCount++;
            if ($contact->activation_date !== null) $attributeCount++;
            if ($contact->file_name !== null) $attributeCount++;
            if ($contact->no_ktp !== null) $attributeCount++;

            if ($attributeCount >= $mostCompleteAttributeCount) {
                $mostCompleteAttributeCount = $attributeCount;
                if(is_null($mostCompleteContact)){
                    $mostCompleteContact = $contact;
                }else{
                    $data = [];
                    if(!is_null($contact->status_no) && (is_null($mostCompleteContact->status_no) || $mostCompleteContact->status_no!=$contact->status_no)) $data['status_no'] = $contact->status_no;
                    if(!is_null($contact->status_wa) && (is_null($mostCompleteContact->status_wa) || $mostCompleteContact->status_wa!=$contact->status_wa)) $data['status_wa'] = $contact->status_wa;
                    if(!is_null($contact->activation_date) && (is_null($mostCompleteContact->activation_date) || $mostCompleteContact->activation_date!=$contact->activation_date)) $data['activation_date'] = $contact->activation_date;
                    if(!is_null($contact->file_name) && (is_null($mostCompleteContact->file_name) || $mostCompleteContact->file_name!=$contact->file_name)) $data['file_name'] = $contact->file_name;
                    if(!is_null($contact->no_ktp) && (is_null($mostCompleteContact->no_ktp) || $mostCompleteContact->no_ktp!=$contact->no_ktp)) $data['no_ktp'] = $contact->no_ktp;
                    $mostCompleteContact->update($data);
                }
            }elseif($attributeCount>0 && !is_null($mostCompleteContact)){
                $data = [];
                if(!is_null($contact->status_no) && (is_null($mostCompleteContact->status_no) || $mostCompleteContact->status_no!=$contact->status_no)) $data['status_no'] = $contact->status_no;
                if(!is_null($contact->status_wa) && (is_null($mostCompleteContact->status_wa) || $mostCompleteContact->status_wa!=$contact->status_wa)) $data['status_wa'] = $contact->status_wa;
                if(!is_null($contact->activation_date) && (is_null($mostCompleteContact->activation_date) || $mostCompleteContact->activation_date!=$contact->activation_date)) $data['activation_date'] = $contact->activation_date;
                if(!is_null($contact->file_name) && (is_null($mostCompleteContact->file_name) || $mostCompleteContact->file_name!=$contact->file_name)) $data['file_name'] = $contact->file_name;
                if(!is_null($contact->no_ktp) && (is_null($mostCompleteContact->no_ktp) || $mostCompleteContact->no_ktp!=$contact->no_ktp)) $data['no_ktp'] = $contact->no_ktp;
                $mostCompleteContact->update($data);
            }

        }
        if ($mostCompleteContact) {
            $deletedContactIds = Contact::where('phone_number', $key)
                ->where('id', '!=', $mostCompleteContact->id)
                ->pluck('id')
                ->toArray();

            Contact::where('phone_number', $key)
                ->where('id', '!=', $mostCompleteContact->id)
                ->delete();

            ClientValidation::whereIn('contact_id', $deletedContactIds)
                ->update(['contact_id' => $mostCompleteContact->id]);
        }

        session()->flash('message', 'Duplicate records processed successfully.');
        $this->findDuplicates(); // Refresh daftar duplikat jika diperlukan
    }
    // private function calculateCompleteness(Contact $contact)
    // {
    //     return collect([
    //         $contact->status_no,
    //         $contact->status_wa,
    //         $contact->activation_date,
    //         $contact->file_name
    //     ])->filter()->count();
    // }

    // private function isComplete(Contact $contact)
    // {
    //     return !empty($contact->status_no) || !empty($contact->status_wa) || !empty($contact->activation_date) || !empty($contact->file_name);
    // }

    public function render()
    {
        return view('livewire.contact.manage-duplicate-contact');
    }
}
