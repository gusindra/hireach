<?php

namespace App\Http\Livewire\Table;

use App\Models\Client;
use App\Models\Company;
use App\Models\Order as ModelsOrder;
use Illuminate\Support\Facades\Auth;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;


class Order extends LivewireDatatable
{
    public $model = ModelsOrder::class;
    public $userId = 0;

    public function builder()
    {
        $auth = Auth::user();
        $client = Client::where('email', $auth->email)->first();

        $query = ModelsOrder::query()->orderBy('created_at', 'desc');

        $isAdmin = $auth->super && $auth->super->first() && $auth->super->first()->role == 'superadmin';
        $isAdmin = $isAdmin || ($auth->activeRole && str_contains($auth->activeRole->role->name, "Admin"));

        if ($isAdmin) {
            if ($this->userId != 0) {
                $query->where('customer_id', $client->uuid)->where('status', '!=', 'draft');
            }
            // No need for else clause as it does not change the query.
        } else {
            $query->where('customer_id', $client->uuid)->where('status', '!=', 'draft');
        }

        return $query;
    }


    public function adminColumns()
    {
        return [
            Column::callback('type', function ($value) {
                if ($value) {
                    return strtoupper($value);
                }
                return '-';
            })->label('Type')->filterable(),
            Column::name('customer_id')->label('Customer'),
            Column::name('no')->label('No'),
            Column::name('name')->label('Name'),
            Column::callback('entity_party', function ($value) {
                if ($value) {
                    $company = cache()->remember('company-', $value, function() use ($value) {
                        return Company::find($value);
                    });
                    return $value.' - '.$company->name;
                }
                return '-';
            })->label('Party')->filterable(),
            DateColumn::name('created_at')->format('d F Y')->label('Created_at')->filterable(),
            Column::name('total')->callback('total', function ($value) {
                if ($value) {
                    return 'Rp' . number_format($value);
                }
                return 0;
            })->label('Total'),
            Column::callback(['status'], function ($status) {
                return view('label.label', ['type' => $status]);
            })->label('Status')->filterable(['DRAFT', 'UNPAID', 'PAID', 'CANCEL']),
            NumberColumn::name('id')->label('Detail')->sortBy('id')->callback('id', function ($value) {
                return view('datatables::link', [
                    'href' => "/admin/order/" . $value,
                    'slot' => 'View'
                ]);
            }),

        ];
    }

    public function userColumns()
    {
        return [
            Column::name('no')->label('No'),
            Column::name('name')->label('Name'),
            Column::callback('company.name', function ($value) {
                if ($value) {
                    return $value;
                }
                return '-';
            })->label('Party')->filterable(),
            DateColumn::name('created_at')->format('d F Y')->label('Created_at')->filterable(),
            Column::name('total')->callback('total', function ($value) {
                if ($value) {
                    return 'Rp' . number_format($value);
                }
                return 0;
            })->label('Total'),
            Column::callback(['status'], function ($status) {
                return view('label.label', ['type' => $status]);
            })->label('Status')->filterable(['UNPAID', 'PAID', 'CANCEL']),
            NumberColumn::name('id')->label('Detail')->sortBy('id')->callback('id', function ($value) {
                return view('datatables::link', [
                    'href' => "order/" . $value,
                    'slot' => 'View'
                ]);
            }),

        ];
    }

    public function columns()
    {
        if ((auth()->user()->super && auth()->user()->super->first() && auth()->user()->super->first()->role == 'superadmin') || (auth()->user()->activeRole && str_contains(auth()->user()->activeRole->role->name, "Admin"))) {
            return $this->adminColumns();
        }
        return $this->userColumns();
    }
}
