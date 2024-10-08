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
        return Contact::query()
            ->join('client_validations', 'contacts.id', '=', 'client_validations.contact_id')
            ->where('client_validations.user_id', auth()->user()->id)
            ->select('contacts.*','client_validations.client_id','client_validations.type'); // Ensure you select all required columns from Contact model
    }

    function columns()
    {
        return [
            Column::name('client_validations.type')->label('Type')->searchable()->filterable(['skip_trace', 'whatsapps', 'cellular_no', 'recycle_status', 'geolocation_tagging']),
            // Column::name('phone_number')->label('Request')->searchable()->filterable(),
            Column::callback(['client_validations.type','no_ktp','phone_number'], function ($type,$ktp,$no) {
                if ($type == 'skip_trace') {
                    return $ktp;
                }else {
                    return $no;
                }
            })->label('Request')->searchable()->filterable(),
            // Column::name('no_ktp')->label('No KTP')->searchable()->filterable(),
            // Column::name('status_no')->label('Status No')->searchable(),
            // Column::name('status_wa')->label('Status WA')->searchable(),
            Column::callback(['client_validations.type','status_no','status_wa','no_ktp','activation_date','phone_number'], function ($type,$no,$wa,$ktp,$date,$pn) {
                if ($type == 'skip_trace') {
                    return $pn ?: ($no ?: $wa);
                }
                elseif ($type == 'cellular_no') {
                    return $no;
                }elseif ($type == 'whatsapps') {
                    return $wa;
                }
            })->label('Result')->searchable()->filterable(),
            DateColumn::name('activation_date')->label('Activation Date')->format('d F Y'),
            DateColumn::name('updated_at')->label('Updated')->format('d F Y H:i:s'),
            DateColumn::name('created_at')->label('Created')->format('d F Y'),
            BooleanColumn::name('file_name')->label('Complete')->unsortable(),
            BooleanColumn::name('client_validations.client_id')->label('Sync')->unsortable()
        ];
    }
}
