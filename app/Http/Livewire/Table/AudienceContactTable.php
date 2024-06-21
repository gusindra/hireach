<?php

namespace App\Http\Livewire\Table;

use App\Models\AudienceClient;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class AudienceContactTable extends LivewireDatatable
{

    public $model = AudienceClient::class;

    public function builder()
    {
        return AudienceClient::query()->with('client');
    }

    public function delete($id)
    {
        AudienceClient::find($id)->delete();
        $this->emit('refreshLivewireDatatable');
    }


    public function columns()
    {
        return [

            Column::name('client.name')->label('Name'),
            Column::name('client.phone')->label('Phone')->searchable(),
            Column::name('client.email')->label('Email'),

            // Column::callback(['id'], function ($id) {
            //     return view('tables.delete-audience-contact', ['id' => $id]);
            // })->label('Actions'),

            Column::callback(['id'], function ($id) {
                return view('tables.delete-audience-clientv2', ['id' => $id]);
            })->unsortable()->label('Actions')


        ];
    }
}
