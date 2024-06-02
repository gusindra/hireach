<?php

namespace App\Http\Livewire\Table;

use App\Models\Notice;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;

class NotificationTable extends LivewireDatatable
{
    public $model = Notice::class;
    public $filterDate;
    public $statusFilter;


    public function builder()
    {
        $query = Notice::query()->where('user_id', auth()->user()->id);
        if(auth()->user()->super && auth()->user()->super->first() && auth()->user()->super->first()->role == 'superadmin'){
            $query = Notice::query()->withTrashed();
        }

        if ($this->filterDate) {
            $query->whereDate('created_at', Carbon::parse($this->filterDate)->toDateString());
        }

        $query->withTrashed();

        if ($this->statusFilter && $this->statusFilter !== 'All') {
            if ($this->statusFilter === 'deleted') {
                $query->onlyTrashed();
            } else {
                $query->where('status', $this->statusFilter);
            }
        }

        return $query->orderBy('created_at', 'DESC');
    }

    public function deleteNotification($id)
    {
        $notification = Notice::findOrFail($id);
        $notification->delete();
        $notification->update(['status' => 'deleted']);
    }

    public function refresh()
    {
        $this->emit('refreshLivewireDatatable');
    }

    private function adminTbl()
    {
        return [
            
            Column::name('user_id')->callback(['user_id'], function ($value) {
                return view('datatables::link', [
                    'href' => "/admin/user/" . $value,
                    'slot' => $value
                ]);
            })->label('User')->filterable()->exportCallback(function ($value) {
                return (string) $value;
            }),
            DateColumn::name('updated_at')->hide()->label('Update Date')->filterable()->format('d-m-Y H:i:s'),
            DateColumn::name('created_at')->label('Creation Date')->sortBy('created_at', 'desc')->filterable()->format('d-m-Y H:i:s'),
            Column::name('type')->label('Name')->searchable()->filterable(),
            Column::name('notification')->truncate(50)->label('Description')->searchable()->filterable(),
            Column::callback(['status'], function ($type) {
                return view('label.label', ['type' => $type]);
            }),
            Column::callback(['status', 'id'], function ($status, $id) {
                $disabled = $status === 'deleted' ? 'disabled' : '';
                return view('datatables::delete-notification', [
                    'id' => $id,
                    'disabled' => $disabled,
                ]);
            })->label('Actions')
        ];
    }

    public function columns()
    {
        if ((auth()->user()->super && auth()->user()->super->first() && auth()->user()->super->first()->role == 'superadmin') || (auth()->user()->activeRole && str_contains(auth()->user()->activeRole->role->name, "Admin"))) {
            return $this->adminTbl();
        }
        return [
            Column::name('type')->label('Name')->searchable(),
            Column::name('notification')->truncate(50)->label('Description')->searchable(),
            DateColumn::name('created_at')->label('Date'),
            Column::callback(['status'], function ($type) {
                return view('label.label', ['type' => $type]);
            }),
            NumberColumn::name('id')->label('Ticket')->sortBy('id')->callback('id', function ($value) {
                return view('datatables::link', [
                    'href' => "/notif-center/" . $value,
                    'slot' => 'View'
                ]);
            }),
            Column::callback(['status', 'id'], function ($status, $id) {

                $disabled = $status === 'deleted' ? 'disabled' : '';

                return view('datatables::delete-notification', [
                    'id' => $id,
                    'disabled' => $disabled,
                ]);
            })->label('Actions'),
        ];
    }
}
