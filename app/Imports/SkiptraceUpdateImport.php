<?php

namespace App\Imports;

use App\Models\Contact;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SkiptraceUpdateImport implements ToCollection, WithHeadingRow
{
    use Importable;

    public function collection(Collection $rows)
    {
        Log::debug($rows);
        foreach ($rows as $row) {
            $no_ktp = $row['no_ktp'];
            $phone_number = $row['no_hp'];
            $activation_date = $row['age'];


            $status_no = null;

            if ($phone_number === 'NIK_NOT_VALID' || $phone_number === '#N/A') {
                $status_no = $phone_number;
                $phone_number = null;
            }

            if ($no_ktp || $phone_number !== null) {
                $contact = Contact::where(function ($query) use ($no_ktp, $phone_number) {
                    if ($no_ktp) {
                        $query->where('no_ktp', $no_ktp);
                    }
                    if ($phone_number !== null) {
                        $query->where('phone_number', $phone_number);
                    }
                })->first();

                if ($contact) {

                    $contact->no_ktp = $no_ktp ?: $contact->no_ktp;
                    $contact->phone_number = $phone_number ?: $contact->phone_number;
                    $contact->activation_date = $activation_date ?: $contact->activation_date;
                    $contact->status_no = $status_no ?: $contact->status_no;
                    $contact->save();
                } else {

                    Contact::create([
                        'no_ktp' => $no_ktp,
                        'phone_number' => $phone_number,
                        'activation_date' => $activation_date,
                        'status_no' => $status_no,
                        'type' => 'skip_trace',
                    ]);
                }
            }
        }
    }
}
