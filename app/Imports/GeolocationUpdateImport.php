<?php

namespace App\Imports;

use App\Models\Contact;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GeolocationUpdateImport implements ToCollection, WithHeadingRow
{
    use Importable;
    protected $fileName;
    protected $userId;

    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $phone_number = trim($row['no_hp'] ?? '');
            $status_no = $row['status'] ?? null;

            $contact = Contact::where('phone_number', $phone_number)->first();
            if ($contact) {
                $contact->update([
                    'geolocation_tag' => $status_no,
                    'file_name' => $this->fileName,
                ]);
            }
        }
    }
}
