<?php

namespace App\Imports;

use App\Models\Contact;
use App\Models\ClientValidation;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;

class PhoneNumberImport implements ToModel
{
    protected $userId;
    protected $type;
    protected $user;
    protected $price;

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
        $phone_number = $row[0] ?? null;

        if (empty($phone_number)) {
            return null;
        }

        if (substr($phone_number, 0, 1) === '0') {
            $phone_number = '62' . substr($phone_number, 1);
        }

        // CHECK BALANCE FIRST BEFORE ADD
        if($balance = checkBalance($this->user->id)){

            if($balance || ($balance > 0 && $balance > $this->price)){
                Log::debug($balance );
                Log::debug($this->price);

                $contact = Contact::firstOrCreate(
                    ['phone_number' => $phone_number],
                    [
                        'phone_number' => $phone_number,
                        'type' => $this->type,
                    ]
                );

                $exists = ClientValidation::where('contact_id', $contact->id)
                    ->where('user_id', $this->userId)
                    ->exists();

                if (!$exists) {
                    ClientValidation::create([
                        'contact_id' => $contact->id,
                        'user_id' => $this->userId,
                        'type' => $this->type,
                    ]);
                }
            }
        }

        return $contact;
    }
}
