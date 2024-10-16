<?php
namespace App\Imports;

use App\Models\Contact;
use App\Models\ClientValidation;
use App\Models\CommerceItem;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;

class SkiptraceImport implements ToModel
{
    protected $userId;
    protected $type;
    protected $user;
    protected $price;
    protected $hasSkippedHeader = false;

    public function __construct($userId, $type, $user = null, $price = 0)
    {
        $this->user = is_null($user) ? User::find($userId) : $user;
        $this->userId = $userId;
        $this->type = $type;
        $this->price = $price;
    }

    /**
     * Define the model creation logic.
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Skip the first row if it's a header or if it doesn't have valid data
        if (!$this->hasSkippedHeader) {
            // Assume headers typically contain non-numeric strings, so we check for a typical header characteristic
            if ($this->isHeader($row)) {
                $this->hasSkippedHeader = true;
                return null;
            }
            $this->hasSkippedHeader = true; // Skip the first row regardless
        }

        // Assume that $row[0] contains 'no_ktp'
        $no_ktp = isset($row[0]) ? $row[0] : null;

        // Skip rows where 'no_ktp' is empty
        if (empty($no_ktp)) {
            return null;
        }

        // CHECK BALANCE FIRST BEFORE ADD
        if($balance = checkBalance($this->user->id)){

            if($balance || ($balance > 0 && $balance > $this->price)){
                Log::debug($balance );
                Log::debug($this->price);

                // Check if a contact with the given 'no_ktp' already exists
                $contact = Contact::where('no_ktp', $no_ktp)->first();
                if (!$contact) {
                    // If no contact exists, create a new one
                    $contact = Contact::create([
                        'no_ktp' => $no_ktp,
                        'type' => $this->type,
                    ]);
                }

                // Link the contact with the ClientValidation table
                ClientValidation::updateOrCreate(
                    [
                        'contact_id' => $contact->id,
                        'user_id' => $this->userId,
                        'type' => $this->type,
                        'price' => $this->type,
                    ],
                    // Add additional fields if necessary
                    []
                );

            }
        }

        return $contact;
    }

    /**
     * Determine if the row is likely a header row.
     *
     * @param array $row
     * @return bool
     */
    protected function isHeader(array $row)
    {
        // Example logic: if all elements of the row are strings, assume it's a header
        foreach ($row as $cell) {
            if (!is_string($cell)) {
                return false;
            }
        }
        return true;
    }
}
