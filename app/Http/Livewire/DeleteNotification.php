<?php

namespace App\Http\Livewire;

use App\Models\Notice;
use Livewire\Component;

class DeleteNotification extends Component
{
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
        $data = Notice::find($this->notificationId);
        $data->delete();
        $data->update(['status' => 'deleted']);

        $this->modalDeleteVisible = false;

        $this->emit('notificationDeleted');
        return redirect()->route('notification');
    }

    public function render()
    {
        return view('livewire.delete-notification');
    }
}
