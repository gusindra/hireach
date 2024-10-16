<?php

namespace App\Http\Livewire\Table;

use Livewire\Component;
use App\Models\Contact;
use App\Models\ClientValidation;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\BooleanColumn;

class UserContactAllTable extends LivewireDatatable
{
    public $model = Contact::class;
    public $export_name = 'DATA_CONTACT';
    public $hideable = 'select';
    public $perPage = "20";

    public function builder()
    {
        return Contact::query();
    }

    public function columns()
    {
        return [

            Column::name('no_ktp')->callback('id', function ($value) {
                $contact = Contact::findOrFail($value);
                return view('datatables::link', [
                    'href' => "/admin/contact/edit/" . $value,
                    'slot' => $contact->no_ktp
                ]);
            })->label('NIK')->searchable(),

            Column::name('status_wa')->label('WhatsApp Status'),
            Column::name('status_no')->label('Number Status'),
            Column::name('type')->label('Type')->searchable(),
            Column::name('phone_number')->label('Phone Number')->searchable(),
            Column::name('file_name')->label('File Name'),
            DateColumn::name('activation_date')->label('Activation Date'),
            DateColumn::name('created_at')->label('Created At')->format('d/m/Y'),
            DateColumn::name('updated_at')->label('Updated At')->format('d/m/Y'),
        ];
    }
}
