<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;

class Delete extends Component
{

    public $userId;
    public $user;
    public $modalDeleteVisible = false;

    public function mount($userId)
    {
        $this->userId = $userId;
        $this->user = User::findOrFail($userId);
    }

    public function render()
    {
        return view('livewire.user.delete');
    }

    public function confirmDelete()
    {
        $this->modalDeleteVisible = true;
    }

    public function delete()
    {
        $this->user->delete();
        $this->modalDeleteVisible = false;
        return redirect()->route('admin.user');
    }
}
