<?php

namespace App\Http\Livewire\Table;

use App\Models\Company;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class Companies extends LivewireDatatable
{
    public $model = Company::class;

    public function builder()
    {
        return Company::query()->orderBy('created_at', 'desc');
    }

    public function columns()
    {
        return [
            Column::callback(['name','id'], function ($name, $id) {
                return view('datatables::link', [
                    'href' => "/admin/setting/company/" . $id,
                    'slot' => strtoupper($name)
                ]);
            })->label('Name')->searchable(),
            // Column::name('id')->label('ID'),
            Column::name('logo')->callback('logo, name', function ($value, $name) {
                if ($value) {
                    return '<img src="https://telixcel.s3.ap-southeast-1.amazonaws.com/' . $value . '" />';
                }
                return $name;
            })->label('Logo'),
            Column::name('person_in_charge')->label('PIC'),
            Column::name('address')->label('Address'),
            NumberColumn::name('id')->label('Action')->sortBy('id')->callback('id', function ($value) {
                // return view('datatables::link', [
                //     'href' => "/admin/setting/company/" . $value,
                //     'slot' => 'View'
                // ]);
            }),

        ];
    }
}
