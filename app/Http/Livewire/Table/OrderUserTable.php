<?php

namespace App\Http\Livewire\Table;

use App\Models\Client;
use App\Models\Company;
use App\Models\Order as ModelsOrder;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class OrderUserTable extends LivewireDatatable
{
    public $model = ModelsOrder::class;
    public $userId = 0;
    public function builder()
    {

        $query = ModelsOrder::query()->orderBy('created_at', 'desc');
        $user = User::find($this->userId);
        $auth = Auth::user();

        $isAdmin = $auth->super && $auth->super->first() && $auth->super->first()->role == 'superadmin';
        $isAdmin = $isAdmin || ($auth->activeRole && str_contains($auth->activeRole->role->name, "Admin"));
        if ($isAdmin) {
            $client = Client::where('email', $user->email)->first();
        } else {
            $client = Client::where('email', $auth->email)->first();
        }


        $query->where('customer_id', $client->uuid);


        $query->where('status', '!=', 'draft');

        return $query;
    }

    public function columns()
    {
        return [
            Column::name('no')->label('No'),

            Column::name('name')->label('Name'),

            Column::callback('company.name', function ($value) {
                return $value ? $value : '-';
            })->label('Party')->filterable(),

            DateColumn::name('created_at')->format('d F Y')->label('Created_at')->filterable(),

            Column::name('total')->callback('total', function ($value) {
                return $value ? 'Rp' . number_format($value) : '0';
            })->label('Total'),

            Column::callback(['status'], function ($status) {
                return view('label.label', ['type' => $status]);
            })->label('Status')->filterable(['UNPAID', 'PAID', 'CANCEL']),

            NumberColumn::name('id')->label('Detail')->sortBy('id')->callback('id', function ($value) {
                $user = Auth::user();
                $href = $user->isSuper() ? "../../order/" . $value : "order/" . $value;
                return view('datatables::link', [
                    'href' => $href,
                    'slot' => 'View'
                ]);
            }),

        ];
    }
}
