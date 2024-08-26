<?php

namespace App\Exports;

use App\Models\Contact;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CellularNoExport implements FromCollection, WithHeadings
{

    /**
     * headings
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'phone_number'
        ];
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Contact::select('phone_number')->where('type', 'cellularno')->where('created_at', Carbon::today())->get();
    }
}
