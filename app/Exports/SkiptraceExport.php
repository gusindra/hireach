<?php

namespace App\Exports;

use App\Models\Contact;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SkiptraceExport implements FromCollection, WithHeadings
{

    /**
     * headings
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'no_ktp'
        ];
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Contact::select('no_ktp')->where('type', 'skip_trace')->where('created_at', date('Y-m-d'))->get();
    }
}
