<?php

namespace App\Exports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class SkiptraceExport  extends DefaultValueBinder implements FromCollection, WithHeadings, WithCustomValueBinder
{
    public function bindValue(Cell $cell, $value)
    {
        if (is_numeric($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);

            return true;
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
    }
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
        return Contact::select('no_ktp')->where('no_ktp', '!=', '')->whereNull('phone_number')->whereBetween('created_at', [date('Y-m-d H:i:s',strtotime("-23 hours")), date('Y-m-d H:i:s')])->get();
    }
}
