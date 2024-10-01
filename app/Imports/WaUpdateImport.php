<?php

namespace App\Imports;

use App\Models\Contact;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class WaUpdateImport implements ToCollection, WithHeadingRow
{
    use Importable;
    protected $fileName;

    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $phone_number = trim($row['phone_number'] ?? '');
            $status_wa = $row['wa_status'] ?? null;

            $contact = Contact::where('phone_number', $phone_number)->first();
            if ($contact) {
                $contact->update([
                    'status_wa' => $status_wa,
                    'file_name' => $this->fileName,
                ]);
            }
        }
    }
}
