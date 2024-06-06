<?php

namespace App\Http\Livewire;

use App\Models\Notification;
use Livewire\Component;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class DeleteNotification extends Component
{
    public $notification;
    public $modalDeleteVisible = false;
    public $actionShowDeleteModal = false;

    public function mount($id)
    {

        $this->notification = Notification::withTrashed()->find($id);
    }

    public function delete($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();
        $notification->update(['status' => 'deleted']);
        $this->emit('LivewireDatatable');
        $this->modalDeleteVisible = false;
        $this->redirect('notif-center');
    }

    public function actionShowDeleteModal()
    {

        if ($this->notification && $this->notification->status != 'deleted') {
            $this->modalDeleteVisible = true;
        }
    }



    public function render()
    {
        return view('livewire.delete-notification');
    }
}
