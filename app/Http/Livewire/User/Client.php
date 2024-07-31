<?php

namespace App\Http\Livewire\User;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use App\Models\User;
use App\Models\Client as ClientModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Client extends Component
{
    use AuthorizesRequests;
    public $name;
    public $email;
    public $phone;
    public $password;
    public $user;
    public $client;

    public function mount(ClientModel $client, User $user)
    {
        $this->user = $user;
        $this->client = $client;
        $this->name = $client->name;
        $this->email = $client->email;
        $this->phone = $client->phone;
        $this->password = '';
    }

    public function generatePassword()
    {
        $this->password = Str::random(12);
    }

    public function update()
    {
        $this->authorize('UPDATE_USER', 'USER');
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:8',
        ]);

        $newUser = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone_no' => $this->phone,
            'password' => Hash::make($this->password),
        ]);
        addLog($newUser);
        return redirect()->route('user.show.client', ['user' => $this->user->id]);
    }

    public function render()
    {
        return view('livewire.user.client');
    }
}
