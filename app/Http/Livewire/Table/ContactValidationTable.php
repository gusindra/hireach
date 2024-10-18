<?php

namespace App\Http\Livewire\Table;

use Livewire\Component;
use App\Models\Contact;
use App\Models\ClientValidation;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\BooleanColumn;

class ContactValidationTable extends LivewireDatatable
{
    public $model = Contact::class;
    public $export_name = 'DATA_CONTACT';
    public $hideable = 'select';

    public function builder()
    {
        // Join with ClientValidation and filter based on logged-in user's ID
        return Contact::query()->orderBy('client_validations.created_at', 'desc')
            ->join('client_validations', 'contacts.id', '=', 'client_validations.contact_id')
            ->where('client_validations.user_id', auth()->user()->id)
            ->select('contacts.*','client_validations.client_id','client_validations.type'); // Ensure you select all required columns from Contact model
    }

    function columns()
    {
        return [
            Column::name('client_validations.type')->label('Type')->searchable()->filterable(['HR-DST', 'HR-WAS', 'HR-CNV', 'HR-NRS', 'HR-GLT']),
            // Column::name('phone_number')->label('Request')->searchable()->filterable(),
            Column::callback(['client_validations.type','no_ktp','phone_number'], function ($type,$ktp,$no) {
                if ($type == 'HR-DST') {
                    return $ktp;
                }else {
                    return $no;
                }
            })->label('Request')->searchable()->filterable(),
            // Column::name('no_ktp')->label('No KTP')->searchable()->filterable(),
            // Column::name('status_no')->label('Status No')->searchable(),
            // Column::name('status_wa')->label('Status WA')->searchable(),
            Column::callback(['client_validations.type','status_no','status_wa','no_ktp','activation_date','phone_number','geolocation_tag','status_recycle'], function ($type,$no,$wa,$ktp,$date,$pn,$geo,$recycle) {
                if ($type == 'HR-DST') {
                    return $pn ? '<table><tr><td>Phone</td><td> : </td><td>'.$pn.'</td></tr><tr><td>Activation</td><td> : </td><td>'.$date.'</td></tr></table>':'';
                }elseif ($type == 'HR-CNV') {
                    return $no;
                }elseif ($type == 'HR-WAS') {
                    return $wa;
                }elseif ($type == 'HR-GLT') {
                    return $geo;
                }elseif ($type == 'HR-NRS') {
                    return $recycle;
                }
            })->label('Result')->searchable()->filterable(),
            // DateColumn::name('activation_date')->label('Activation Date')->format('d F Y'),
            DateColumn::name('client_validations.updated_at')->label('Updated')->format('d F Y H:i:s'),
            DateColumn::name('client_validations.created_at')->label('Created')->format('d F Y'),
            BooleanColumn::name('client_validations.status')->label('Complete')->unsortable(),
            BooleanColumn::name('client_validations.client_id')->label('Sync')->unsortable()
        ];
    }
}
