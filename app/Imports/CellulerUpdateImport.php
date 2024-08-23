<?php

namespace App\Imports;

use App\Models\Contact;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CellulerUpdateImport implements ToCollection, WithHeadingRow
{
    use Importable;
    protected $fileName;
    protected $userId;

    public function __construct($fileName,$userId)
    {
        $this->fileName = $fileName;
        $this->userId = $userId;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $phone_number = trim($row['no_hp'] ?? '');
            $status_no = $row['status'] ?? null;

            $contact = Contact::where('phone_number', $phone_number)->first();
            if ($contact) {
                $contact->update([
                    'status_no' => $status_no,
                    'file_name' => $this->fileName,
                ]);
            }
        }
    }
}
