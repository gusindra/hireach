<?php

namespace App\Imports;

use App\Models\Contact;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
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
            $keys = array_keys(json_decode($row, true));
            foreach($keys as $k => $key){
                if($k==0){ $phone_number = trim($row[$key] ?? '');}
                elseif($k==1) {$status = $row[$key] ?? null;}
            }

            $contact = Contact::where('phone_number', $phone_number)->first();
            if ($contact) {
                $contact->update([
                    'status_wa' => $status,
                    'file_name' => $this->fileName,
                ]);
            }
        }
    }
}
