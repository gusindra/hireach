<?php

namespace App\Http\Livewire\Contact;

use App\Models\BillingUser;
use App\Models\Client;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Illuminate\Support\Str;

class Profile extends Component
{
    use AuthorizesRequests;
    public $user;
    public $client;
    public $inputuser;
    public $inputclient;

    public function mount($user)
    {
        $this->user = $user;

        $this->inputuser = [
            'name' => $this->user->name ?? '',
            'nick' => $this->user->nick ?? '',
            'email' => $this->user->email ?? '',
            'phone' => $this->user->phone ?? '',
            'source' => $this->user->source ?? '',
            'title' => $this->user->title ?? '',
            'sender' => $this->user->sender ?? '',
            'identity' => $this->user->identity ?? '',
            'user_id' => $this->user->user_id ?? '',
            'note' => $this->user->note ?? '',
            'tag' => $this->user->tag ?? '',
            'address' => $this->user->address ?? '',
        ];
        //dd($this->inputuser);
    }

    public function saveUser($id)
    {
        //dd($this->inputuser);
        $user = Client::findOrFail($id);
        if ($this->user->isClient && $user->email != $this->inputuser['email']) {
            $this->user->isClient->update([
                'email' => $this->inputuser['email']
            ]);
        }
        $user->update([
            'sender' => $this->inputuser['sender'],
            'name' => $this->inputuser['name'],
            'phone' => $this->inputuser['phone'],
            'identity' => $this->inputuser['identity'],
            'user_id' => $this->inputuser['user_id'],
            'note' => $this->inputuser['note'],
            'tag' => $this->inputuser['tag'],
            'source' => $this->inputuser['source'],
            'email' => $this->inputuser['email'],
            'address' => $this->inputuser['address'],
            'title' => $this->inputuser['title'],

        ]);


        $this->emit('user_saved');
    }

    public function saveClient()
    {
        if ($this->user->isClient) {
            $this->user->isClient->update([
                'title' => $this->inputclient['title'],
                'name' => $this->inputclient['name'],
                'phone' => $this->inputclient['phone'],
                'address' => $this->inputclient['address'],
                'note' => $this->inputclient['notes'],
            ]);
            if (!$this->user->userBilling) {
                $billing = BillingUser::create([
                    'tax_id' => $this->inputclient['tax_id'],
                    'name' => $this->inputclient['name'],
                    'post_code' => $this->inputclient['postcode'],
                    'address' => $this->inputclient['address'],
                    'province' => $this->inputclient['province'],
                    'city' => $this->inputclient['city'],
                    'user_id' => $this->user->id
                ]);
            } else {
                $this->user->userBilling->update([
                    'tax_id' => $this->inputclient['tax_id'],
                    'name' => $this->inputclient['name'],
                    'post_code' => $this->inputclient['postcode'],
                    'address' => $this->inputclient['address'],
                    'province' => $this->inputclient['province'],
                    'city' => $this->inputclient['city'],
                ]);
            }
        } else {
            $customer = Client::create([
                'title' => $this->inputclient['title'],
                'name' => $this->inputclient['name'],
                'phone' => $this->inputclient['phone'],
                'address' => $this->inputclient['address'],
                'note' => $this->inputclient['notes'],
                'email' => $this->user->email,
                'user_id' => 0,
                'uuid' => Str::uuid()
            ]);
            $team = Team::find(0);
            $customer->teams()->attach($team);
            if ($customer) {
                $billing = BillingUser::create([
                    'tax_id' => $this->inputclient['tax_id'],
                    'name' => $this->inputclient['name'],
                    'post_code' => $this->inputclient['postcode'],
                    'address' => $this->inputclient['address'],
                    'province' => $this->inputclient['province'],
                    'city' => $this->inputclient['city'],
                    'user_id' => $this->user->id
                ]);
            }
        }
        $this->emit('client_saved');
    }

    public function render()
    {
        $this->authorize('VIEW_RESOURCE_USR', $this->user->user_id);
        return view('livewire.contact.profile');
    }
}
