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
    public $filterDate = null;
    public $statusFilter = 'All';


    /**
     * builder
     *
     * @return void
     */
    public function builder()
    {
        $query = Notice::query();

        if (auth()->user()->isSuper || (auth()->user()->team && str_contains(auth()->user()->activeRole->role->name, 'Admin'))) {
            $query = $query->withTrashed();
        } else {
            $query = $query->where('user_id', auth()->user()->id);
        }
        // if ($this->filterDate) {
        //     $query->whereDate('created_at', Carbon::parse($this->filterDate)->toDateString());
        // }


        if ($this->statusFilter && $this->statusFilter !== 'All') {
            if ($this->statusFilter === 'deleted') {
                $query->onlyTrashed();
            } else {
                $query->where('status', $this->statusFilter);
            }
        }
        return $query->orderBy('created_at', 'DESC');
    }

    /**
     * deleteNotification
     *
     * @param  mixed $id
     * @return void
     */
    public function deleteNotification($id)
    {
        $notification = Notice::findOrFail($id);
        $notification->delete();
        $notification->update(['status' => 'deleted']);
    }

    /**
     * refresh
     *
     * @return void
     */
    public function refresh()
    {
        $this->emit('refreshLivewireDatatable');
    }

    /**
     * adminTbl
     *
     * @return mixed array
     */
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
                $html = '<div class="flex">';
                $html = $html . view('datatables::link', [
                    'href' => "/notif-center/" . $id,
                    'slot' => 'View'
                ]);
                $disabled = $status === 'deleted' ? 'disabled' : '';
                $html = $html . view('tables.delete-notification', [
                    'notificationId' => $id,
                    'disabled' => $disabled,
                ]);
                return $html . "</div>";
            })->label('Actions')
        ];
    }

    /**
     * columns
     *
     * @return mixed array
     */
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
            })->label('Status'),
            Column::callback(['status', 'id'], function ($status, $id) {
                $html = '<div class="flex">';
                $html = $html . view('datatables::link', [
                    'href' => "/notif-center/" . $id,
                    'slot' => 'View'
                ]);
                $disabled = $status === 'deleted' ? 'disabled' : '';
                $html = $html . view('tables.delete-notification', [
                    'id' => $id,
                    'disabled' => $disabled,
                ]);
                return $html . "</div>";
            })->label('Actions'),
        ];
    }
}
