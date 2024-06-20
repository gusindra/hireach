<?php

namespace App\Http\Livewire\Table;

use App\Models\Audience;
use App\Models\AudienceClient;
use Livewire\Component;
use App\Models\Client;
use Illuminate\Support\Str;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class ListContactAdd extends LivewireDatatable
{
    public $model = Client::class;
    public $export_name = 'DATA_CLIENT';
    public $audience;



    public function builder()
    {
        $userId = auth()->user()->currentTeam->user_id;

        $excludedUuids = AudienceClient::where('audience_id', $this->audience->id)->pluck('client_id');

        return Client::where('user_id', $userId)
            ->whereNotIn('uuid', $excludedUuids);
    }
    function columns()
    {
        return [

            Column::name('name')->label('Name')->searchable(),
            Column::name('phone')->label('Phone Number')->searchable(),
            Column::name('email')->label('Email')->searchable(),
            Column::callback(['id'], function ($id) {
                return view('tables.add-contact-to-audience', ['id' => $id]);
            })->unsortable()->label('Actions')

        ];
    }

    public function add($id)
    {
        $client = Client::find($id);
        AudienceClient::firstOrCreate([
            'audience_id' => $this->audience->id,
            'client_id' => $client->uuid
        ]);
    }
}
