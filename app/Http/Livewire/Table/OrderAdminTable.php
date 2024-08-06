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

class OrderAdminTable extends LivewireDatatable
{
    public $model = ModelsOrder::class;
    public $userId = 0;

    public function builder()
    {
        $query = ModelsOrder::query()->orderBy('created_at', 'desc');
        return $query;
    }

    public function columns()
    {
        return [
            Column::callback('type', function ($value) {
                return $value ? strtoupper($value) : '-';
            })->label('Type')->filterable(),

            Column::name('customer_id')->label('Customer'),

            Column::name('no')->label('No'),

            Column::name('name')->label('Name'),

            Column::callback('entity_party', function ($value) {
                if ($value) {
                    $company = cache()->remember('company-' . $value, 3600, function () use ($value) {
                        return Company::find($value);
                    });
                    return $value . ' - ' . ($company ? $company->name : '-');
                }
                return '-';
            })->label('Party')->filterable(),

            DateColumn::name('created_at')->format('d F Y')->label('Created_at')->filterable(),

            Column::name('total')->callback('total', function ($value) {
                return $value ? 'Rp' . number_format($value) : '0';
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
}
