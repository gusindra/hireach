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
            Column::callback(['status'], function ($status) {
                return view('label.label', ['type' => $status]);
            })->label('Status')->filterable(['DRAFT', 'UNPAID', 'PAID', 'CANCEL']),
            Column::callback('type', function ($value) {
                return $value ? strtoupper($value) : '-';
            })->label('Type')->filterable(['SELLING', 'TOPUP', "OTHER"]),
            Column::callback(['no','id'], function ($name, $id) {
                return view('datatables::link', [
                    'href' => "/admin/order/" . $id,
                    'slot' => strtoupper($name)
                ]);
            })->label('Code')->searchable()->filterable(),
            Column::name('total')->callback('total', function ($value) {
                // return (int) $value;
                return $value ? 'Rp' . number_format($value) : 0;
            })->label('Total')->filterable()->enableSummary(),
             
            Column::name('name')->label('Name')->filterable()->group('group2'),
 
            DateColumn::name('created_at')->format('d F Y')->label('Created_at')->filterable(),
            
            Column::callback(['customer_id'], function ($id) {
                return view('datatables::link', [
                    'href' => "/admin/user/" . $id,
                    'slot' => $id
                ]);
            })->label('Customer')->searchable()->filterable(),
            
            Column::callback('entity_party', function ($value) {
                if ($value) {
                    $company = cache()->remember('company-' . $value, 3600, function () use ($value) {
                        return Company::withTrashed()->find($value);
                    });
                    return $value . ' - ' . ($company ? $company->name : '-');
                }
                return '-';
            })->label('Party')->group('group2'),
        ];
    }
}
