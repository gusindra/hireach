<?php

namespace App\Http\Livewire\Table;

use App\Models\Client;
use App\Models\User; // Import model User
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;

class ClientToUser extends LivewireDatatable
{
    public $model = Client::class;
    public $user;

    public $params = ['user'];

    public function builder()
    {
        $query = Client::query();

        if (!empty($this->user)) {
            $query->where('user_id', $this->user->id);
        }

        return $query;
    }

    public function columns()
    {
        return [
            Column::name('name')->label('Name'),
            Column::name('phone')->label('Phone'),
            Column::name('email')->label('Email'),
            NumberColumn::name('id')->label('Detail')->sortBy('id')->callback(['id'], function ($id) {
                $client = Client::find($id);

                // Mengecek apakah tidak ada user dengan alamat email yang sama dengan klien
                $userWithEmailExists = User::where('email', $client->email)->exists();

                if (!$userWithEmailExists && $this->user && $client && $this->user->email !== $client->email) {
                    return view('datatables::link', [
                        'href' => url('admin/user/' . $this->user->id . '/client/' . $id),
                        'slot' => 'Convert to User'
                    ]);
                }

                return '';
            }),
        ];
    }
}
