<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;

class Edit extends Component
{
    public $userId;
    public $user;
    public $inputuser;
    public function mount($userId)
    {
        $this->userId = $userId;
        $this->user = User::findOrFail($userId);

        $this->inputuser['name'] = $this->user->name ?? '';
        $this->inputuser['email'] = $this->user->email ?? '';
    }

    public function updateUser($id)
    {
        $user = User::find($id);
        $user->update([
            'name'      => $this->inputuser['name'],
            'email'     => $this->inputuser['email'],
        ]);
        $this->emit('userSaved');
    }

    public function render()
    {
        return view('livewire.user.edit', [
            'user' => $this->user
        ]);
    }
}
