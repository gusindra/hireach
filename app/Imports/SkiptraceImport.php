<?php

namespace App\Imports;

use App\Models\Contact;
use App\Models\ClientValidation;
use Maatwebsite\Excel\Concerns\ToModel;

class SkiptraceImport implements ToModel
{
    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Define the model creation logic.
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Assume that $row[0] contains 'no_ktp'
        $no_ktp = isset($row[0]) ? $row[0] : null;

        // Skip rows where 'no_ktp' is empty
        if (empty($no_ktp)) {
            return null;
        }

        // Check if a contact with the given 'no_ktp' already exists
        $contact = Contact::where('no_ktp', $no_ktp)->first();

        if (!$contact) {
            // If no contact exists, create a new one
            $contact = Contact::create([
                'no_ktp' => $no_ktp,
                'type' => 'skip_trace',
            ]);
        }

        // Link the contact with the ClientValidation table
        ClientValidation::updateOrCreate(
            [
                'contact_id' => $contact->id,
                'user_id' => $this->userId,
            ],
            // Add additional fields if necessary
            []
        );

        return $contact;
    }
}
