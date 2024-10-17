<?php

namespace App\Http\Livewire;

use App\Models\BlastMessage;
use App\Models\Provider;
use App\Models\User;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;

class ProviderUsageTable extends LivewireDatatable
{
    public $provider;

    public function builder()
    {
        return BlastMessage::query()->where('provider', $this->provider->id);
    }

    public function columns()
    {
        return [
            Column::callback('user_id', function ($userId) {
                $user = User::find($userId);
                return $user ? $user->name : 'Unknown User';
            })->label('User'),

            // Contoh kolom lain
            Column::name('message_content')
                ->label('Message Content')
                ->truncate(50)
                ->searchable(),

            DateColumn::name('created_at')
                ->label('Date Sent')
        ];
    }
}
