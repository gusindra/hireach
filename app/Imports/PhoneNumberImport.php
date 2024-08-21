<?php

namespace App\Imports;

use App\Models\Contact;
use App\Models\ClientValidation;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;

class PhoneNumberImport implements ToModel
{
    protected $userId;
    protected $type;

    public function __construct($userId, $type)
    {
        $this->userId = $userId;
        $this->type = $type;
    }

    /**
     * Define the model creation logic.
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        Log::debug($this->type);
        $phone_number = $row[0] ?? null;

        if (empty($phone_number)) {
            return null;
        }

        // Check if the phone number starts with '0' and replace it with '62'
        if (substr($phone_number, 0, 1) === '0') {
            $phone_number = '62' . substr($phone_number, 1);
        }

        $contact = Contact::updateOrCreate(
            ['phone_number' => $phone_number],
            [
                'phone_number' => $phone_number,
                'type' => $this->type,
            ]
        );
        
        ClientValidation::create([
            'contact_id' => $contact->id,
            'user_id' => $this->userId,
            'type' => $this->type,
        ]);

        return $contact;
    }
}
