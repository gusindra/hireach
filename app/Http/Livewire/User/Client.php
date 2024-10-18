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
    public $title;
    public $password;
    public $user;
    public $client;
    public $isUser;

    public function mount(ClientModel $client, User $user)
    {

        $this->user = $user;
        $this->client = $client;
        $this->name = $client->name;
        $this->email = $client->email;
        $this->phone = $client->phone;
        $this->password = '';
        $this->isUser = User::where('phone_no', $this->phone)->exists();
    }

    public function generatePassword()
    {
        $this->password = Str::random(12);
    }

    /**
     * update
     *
     * @return void
     */
    public function update()
    {
        $this->authorize('UPDATE_USER', 'USER');
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:8',
        ]);

        if($this->name != $this->client->name || $this->phone != $this->client->phone || $this->email != $this->client->email || $this->title != $this->client->title){
            $this->client->update([
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
                'title' => $this->title
            ]);
            $this->emit('user_saved');
        }
    }

    /**
     * update
     *
     * @return void
     */
    public function addToUser()
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

        if($this->name != $this->client->name || $this->phone != $this->client->phone || $this->email != $this->client->email || $this->title != $this->client->title){
            $this->client->update([
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
                'title' => $this->title
            ]);
            $this->emit('user_saved');
        }
        return redirect()->route('user.show.client', ['user' => $this->user->id]);
    }

    public function render()
    {
        return view('livewire.user.client');
    }
}
