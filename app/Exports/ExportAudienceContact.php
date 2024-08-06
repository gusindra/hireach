<?php

namespace App\Exports;

use App\Models\Audience;
use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportAudienceContact implements FromCollection, WithHeadings {
    public $audienceId;

    public function __construct(int $audienceId)
    {
        $this->audienceId = $audienceId;
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
        $audience = Audience::find($this->audienceId);
        $clientId = $audience->audienceClients->pluck('client_id');
        return Client::whereIn('uuid', $clientId)->select('name','sender','phone','title','email','identity','created_at','address','tag','note')->where('user_id', auth()->user()->id)->get()->each(function($row){
            $row->setHidden(['profile_photo_url', 'date', 'active']);
        });;
    }
}
