<?php

namespace App\Http\Livewire\Table;


use App\Models\Quotation as ModelsQuotation;
use Illuminate\Support\Facades\Auth;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;

class Quotation extends LivewireDatatable
{
    public $model = ModelsQuotation::class;


    public function builder()
    {
        $auth = Auth::user();
        $query = ModelsQuotation::query()->orderBy('quotations.created_at', 'desc');
        if (auth()->user()->super && auth()->user()->super->first() && auth()->user()->super->first()->role == 'superadmin') {
            $query->with('users');
        } elseif (auth()->user()->activeRole && str_contains(auth()->user()->activeRole->role->name, "Admin")) {
            $query;
        } else {
            $query->where('model_id', $auth->id)->where('quotations.status', '!=', 'draft');
        }


        return $query;
    }

    private function adminColumns()
    {
        return [
            Column::callback(['title','id'], function ($name, $id) {
                return view('datatables::link', [
                    'href' => "/admin/quotation/" . $id,
                    'slot' => strtoupper($name)
                ]);
            })->label('Quotation')->filterable()->searchable(),
            Column::name('model')->callback('model, model_id', function ($m, $mi) {
                if ($m == 'USER') {
                    return $m . ' : '. $mi;
                }
                return $m;
            })->label('Source')->filterable(),
            DateColumn::name('date')->label('Date')->format('d F Y')->filterable(),
            NumberColumn::name('valid_day')->label('Duration (Day)')->filterable(),
            Column::callback(['status'], function ($status) {
                return view('label.label', ['type' => $status]);
            })->label('Status')->filterable(['DRAFT', 'APPROVED', 'SUBMIT']),
        ];
    }

    private function userColumns()
    {
        return [
            Column::name('title')->label('Title'),
            Column::name('model')->callback('model, model_id, project.name, company.name, client.name', function ($m, $mi, $pn, $com, $cn) {
                if ($m == 'PROJECT') {
                    return $m . ' : ' . $pn;
                } elseif ($m == 'COMPANY') {
                    return $m . ' : ' . $com;
                } elseif ($m == 'CLIENT') {
                    return $m . ' : ' . $cn;
                }
                return $m;
            })->label('Source')->filterable(),
            DateColumn::name('date')->label('Date')->filterable(),
            NumberColumn::name('valid_day')->label('Duration (Day)')->filterable(),
            Column::callback(['status'], function ($status) {
                return view('label.label', ['type' => $status]);
            })->label('Status')->filterable(['DRAFT', 'APPROVED', 'SUBMIT']),
            NumberColumn::name('id')->label('Detail')->sortBy('id')->callback('id', function ($value) {
                return view('datatables::link', [
                    'href' => "quotation/" . $value,
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
