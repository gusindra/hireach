<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportWeTalkContact implements FromCollection, WithHeadings {
    public $msid;

    public function __construct(array $msid)
    {
        $this->msid = $msid;
    }
    /**
     * headings
     *
     * @return array
     */
    public function headings(): array {
        return [
            'name','nick_name','phone','title','email','gender','birthday','address','tags','note'
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Client::whereIn('phone', $this->msid)->select('name','sender','phone','title','email','identity','created_at','address','tag','note')->where('user_id', auth()->user()->id)->get()->each(function($row){
            $row->setHidden(['profile_photo_url', 'date', 'active']);
        });;
    }
}
