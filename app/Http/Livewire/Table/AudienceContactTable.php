<?php

namespace App\Http\Livewire\Table;

use App\Models\AudienceClient;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class AudienceContactTable extends LivewireDatatable
{
    public $model = AudienceClient::class;
    public $audienceId;

    public function builder()
    {

        $query = AudienceClient::query()
            ->join('clients', 'clients.uuid', '=', 'audience_clients.client_id')
            ->select('audience_clients.*', 'clients.name', 'clients.phone', 'clients.email')
            ->where('audience_clients.audience_id', $this->audienceId);

        if ($this->search) {
            $query->where(function ($query) {
                $query->where('clients.name', 'like', '%' . $this->search . '%')
                    ->orWhere('clients.phone', 'like', '%' . $this->search . '%')
                    ->orWhere('clients.email', 'like', '%' . $this->search . '%');
            });
        }

        return $query;
    }

    public function delete($id)
    {
        AudienceClient::find($id)->delete();
        $this->emit('refreshLivewireDatatable');
    }

    public function columns()
    {
        return [
            Column::name('clients.name')->label('Name'),
            Column::name('clients.phone')->label('Phone')->searchable(),
            Column::name('clients.email')->label('Email'),
            Column::callback(['id'], function ($id) {
                return view('tables.delete-audience-clientv2', ['id' => $id]);
            })->unsortable()->label('Actions')
        ];
    }

    public function searchColumns()
    {
        return [
            'clients.name',
            'clients.phone',
            'clients.email'
        ];
    }
}
