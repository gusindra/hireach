<?php

namespace App\Http\Livewire;

use App\Models\Notice;
use Livewire\Component;

class DeleteNotification extends Component
{
    public $notificationId;
    public $notification;
    public $modalDeleteVisible = false;

    public function mount($id)
    {
        $this->notification = Notice::withTrashed()->find($id);
    }

    public function showDeleteModal($id)
    {
        $this->notificationId = $id;
        $this->modalDeleteVisible = true;
    }

    public function deleteNotification()
    {
        Notice::destroy($this->notificationId);
        $this->notification->update(['status' => 'deleted']);

        $this->modalDeleteVisible = false;

        $this->emit('notificationDeleted');
        return redirect()->route('notification');
    }

    public function render()
    {
        return view('livewire.delete-notification');
    }
}
