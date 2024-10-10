<?php

namespace App\Exports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class ContactsExport implements FromCollection, WithHeadings
{
    protected $type;
    protected $fileName;

    public function __construct($type, $fileName)
    {
        $this->type = $type;
        $this->fileName = $fileName;
    }

    public function collection()
    {
        if ($this->type == 'skip_trace') {
            return Contact::where('file_name', 'like', '%' . $this->fileName . '%')
                ->select('no_ktp', 'status_no', 'status_wa', 'phone_number', 'activation_date')
                ->get()
                ->map(function ($contact) {
                    $result = $contact->status_no ?? $contact->status_wa ?? $contact->phone_number;

                    return [
                        'no_ktp' => $contact->no_ktp ? '="' . $contact->no_ktp . '"' : '',
                        'result' => $result ?: '',
                        'reg_date' => $contact->activation_date ? Carbon::parse($contact->activation_date)->addDay()->format('Y-m-d') : '',
                    ];
                });
        } elseif ($this->type == 'whatsapp') {
            return Contact::where('file_name', 'like', '%' . $this->fileName . '%')
                ->select('phone_number', 'status_wa')
                ->get()
                ->map(function ($contact) {
                    return [

                        'no_hp' => $contact->phone_number ? '="' . $contact->phone_number . '"' : '',
                        'status' => $contact->status_wa,
                    ];
                });
        } elseif ($this->type == 'celluler_no') {
            return Contact::where('file_name', 'like', '%' . $this->fileName . '%')
                ->select('phone_number', 'status_no')
                ->get()
                ->map(function ($contact) {
                    return [
                        'no_hp' => $contact->phone_number ? '="' . $contact->phone_number . '"' : '',
                        'status' => $contact->status_no,
                    ];
                });
        } else {
            return collect([]);
        }
    }


    public function headings(): array
    {
        if ($this->type === 'skip_trace') {
            return ['no_ktp', 'result', 'reg_date'];
        } elseif ($this->type === 'whatsapp') {
            return ['no_hp', 'status'];
        } elseif ($this->type === 'celluler_no') {
            return ['no_hp', 'status'];
        }
    }
}
