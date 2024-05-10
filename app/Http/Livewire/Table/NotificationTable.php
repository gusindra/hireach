<?php

namespace App\Http\Livewire\Table;

use App\Models\Notification;
use Carbon\Carbon;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;

class NotificationTable extends LivewireDatatable
{
    public $model = Notification::class;
    public $filterDate;
    public $statusFilter;

    public function __construct($statusFilter = null)
    {

        $this->filterDate = Carbon::now()->format('d-m-y');
        $this->statusFilter = $statusFilter;
    }

    public function builder()
    {
        $query = Notification::query()->where('user_id', auth()->user()->id);

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
    public function updatedStatusFilter()
    {
        dd(1);
    }




    public function deleteNotification($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();
        $notification->update(['status' => 'deleted']);
    }

    public function refresh()
    {
        $this->emit('refreshLivewireDatatable');
    }


    public function columns()
    {
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
