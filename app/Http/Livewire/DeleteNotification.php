<?php

namespace App\Http\Livewire;

use App\Models\Notice;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class DeleteNotification extends Component
{
    use AuthorizesRequests;
    public $notificationId;
    public $notification;
    public $modalDeleteVisible = false;

    public function mount()
    {
        $this->notification = Notice::withTrashed()->find($this->notificationId);
    }

    public function showDeleteModal()
    {

        $this->modalDeleteVisible = true;
    }

    public function deleteNotification()
    {
        $this->authorize('DELETE_NOTICE', 'NOTICE');
        $data = Notice::find($this->notificationId);
        $data->delete();
        $data->update(['status' => 'deleted']);
        addLog(null, $data);
        $this->modalDeleteVisible = false;

        $this->emit('notificationDeleted');
        return redirect()->route('notification');
    }

    public function render()
    {
        return view('livewire.delete-notification');
    }
}
