<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportContact implements FromCollection, WithHeadings {

    /**
     * headings
     *
     * @return array
     */
    public function headings(): array {
        return [
            'name','phone','email','created_at','title','sender','identity','note','tag','source','address'
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Client::select('name','phone','email','created_at','title','sender','identity','note','tag','source','address')->where('user_id', auth()->user()->id)->get()->each(function($row){
            $row->setHidden(['profile_photo_url', 'date', 'active']);
        });;
    }
}
