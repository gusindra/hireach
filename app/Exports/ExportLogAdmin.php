<?php

namespace App\Exports;

use App\Models\LogChange;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportLogAdmin implements FromCollection, WithHeadings
{

    /**
     * headings
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'model', 'model_id', 'before', 'remark', 'user_id', 'created_at', 'updated_at'
        ];
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return LogChange::select('model', 'model_id', 'before', 'remark', 'user_id', 'created_at', 'updated_at')->get()->each(function ($row) {
            //$row->setHidden(['profile_photo_url', 'date', 'active']);
        });;
    }
}
