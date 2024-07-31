<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Delete extends Component
{
    use AuthorizesRequests;
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
        $this->authorize('DELETE_USER', 'USER');
        $this->modalDeleteVisible = true;
    }

    public function delete()
    {
        $this->authorize('DELETE_USER', 'USER');
        $this->user->delete();
        addLog(null, $this->user);
        $this->modalDeleteVisible = false;
        return redirect()->route('admin.user');
    }
}
