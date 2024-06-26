<?php

namespace App\Http\Livewire;

use App\Models\BlastMessage;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;

class SmsBlastTable extends LivewireDatatable
{
    public $model = Client::class;
    public $userId;
    public $month;
    public $year;

    public function builder()
    {
        if (auth()->user()->super && auth()->user()->super->first() && auth()->user()->super->first()->role == 'superadmin') {
            return BlastMessage::query();
        }
        return BlastMessage::query()->where('blast_messages.user_id', auth()->user()->currentTeam->user_id)->orderBy('created_at', 'desc');
    }

    private function clientTbl()
    {
        return [
            Column::callback(['client_id'], function ($client_id, $client_name) {
                if ($client_name != '' && !is_null($client_name)) {
                    return $client_name;
                }
                return $client_id;
            })->filterable()->label('Client ID')->truncate(12),
            Column::name('msisdn')->label('Phone No')->filterable(),
            Column::name('message_content')->label('Message Content')->truncate(50)->filterable(),
            Column::name('status')->label('Status')->filterable(['DELIVERED', 'UNDELIVERED', 'ACCEPTED', 'PROCESSED']),
            DateColumn::name('created_at')->label('Creation Date')->sortBy('created_at', 'desc')->filterable()->alignRight(),
            DateColumn::raw('blast_messages.created_at AS created_at2')->label('Time')->format('H:i'),
        ];
    }

    private function adminTbl()
    {
        return [
            Column::name('user_id')->label('User ID')->filterable(),
            Column::name('created_at')->label('Creation Date')->sortBy('created_at', 'desc')->filterable(),
            Column::name('status')->label('Status')->filterable(['DELIVERED', 'UNDELIVERED', 'ACCEPTED', 'PROCESSING', 'PROCESSED']),
            Column::name('price')->label('Price'),
            Column::name('msg_id')->label('Sending ID'),
            Column::name('client_id')->label('Client')->filterable(),
            Column::name('message_content')->label('Message Content'),
            Column::name('msisdn')->label('Phone No')->filterable(),
        ];
    }

    public function columns()
    {
        if (auth()->user()->super && auth()->user()->super->first() && auth()->user()->super->first()->role == 'superadmin') {
            return $this->adminTbl();
        }
        return $this->clientTbl();
    }
}
