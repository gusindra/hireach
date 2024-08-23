<?php

namespace App\Http\Livewire\Table;

use Livewire\Component;
use App\Models\Contact;
use App\Models\ClientValidation;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

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
            ->select('contacts.*'); // Ensure you select all required columns from Contact model
    }

    function columns()
    {
        return [
            Column::name('phone_number')->label('Phone Number')->searchable(),

            Column::name('no_ktp')->label('No KTP')->searchable(),

            Column::name('type')->label('Type')->searchable(),

            Column::name('status_no')->label('Status No')->searchable(),

            Column::name('status_wa')->label('Status WA')->searchable(),

            DateColumn::name('activation_date')->label('Activation Date')->format('d F Y'),

            DateColumn::name('created_at')->label('Created Date')->format('d F Y'),
        ];
    }
}
