<?php

namespace App\Exports;

use App\Models\Contact;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RecyclingNoExport implements FromCollection, WithHeadings
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
        return Contact::select('phone_number')->where('type', 'recycle_status')->where('phone_number', '!=', '')->whereNull('status_wa')->whereBetween('created_at', [date('Y-m-d H:i:s',strtotime("-23 hours")), date('Y-m-d H:i:s')])->get();
    }
}
