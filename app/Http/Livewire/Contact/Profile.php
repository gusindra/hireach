<?php

namespace App\Http\Livewire\Contact;

use App\Models\BillingUser;
use App\Models\Client;
use App\Models\Team;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;

class Profile extends Component
{
    public $user;
    public $client;
    public $inputuser;
    public $inputclient;

    public function mount($user)
    {
        //dd($user);
        $this->user = Client::find($user->id);

        $this->inputuser['name'] = $this->user->name ?? '';
        $this->inputuser['nick'] = $this->user->nick ?? '';
        $this->inputuser['email'] = $this->user->email ?? '';
        $this->inputuser['phone'] = $this->user->phone ?? '';
        $this->inputuser['title'] = $this->user->title ?? '';
        //dd($this->inputuser);
    }

    public function saveUser($id)
    {
        // dd($id);
        $user = User::find($id);
        if($this->user->isClient && $user->email != $this->inputuser['email']){
            $this->user->isClient->update([
                'email' => $this->inputuser['email']
            ]);
        }
        $user->update([
            'name'      => $this->inputuser['name'],
            'phone_no'  => $this->inputuser['phone'],
            'email'     => $this->inputuser['email'],
            'nick'      => $this->inputuser['nick']
        ]);
        $this->emit('user_saved');
    }

    public function saveClient()
    {
        if($this->user->isClient){
            $this->user->isClient->update([
                'title'     => $this->inputclient['title'],
                'name'      => $this->inputclient['name'],
                'phone'     => $this->inputclient['phone'],
                'address'   => $this->inputclient['address'],
                'note'      => $this->inputclient['notes'],
            ]);
            if(!$this->user->userBilling){
                $billing = BillingUser::create([
                    'tax_id'        => $this->inputclient['tax_id'],
                    'name'          => $this->inputclient['name'],
                    'post_code'     => $this->inputclient['postcode'],
                    'address'       => $this->inputclient['address'],
                    'province'      => $this->inputclient['province'],
                    'city'          => $this->inputclient['city'],
                    'user_id'       => $this->user->id
                ]);
            }else{
                $this->user->userBilling->update([
                    'tax_id'        => $this->inputclient['tax_id'],
                    'name'          => $this->inputclient['name'],
                    'post_code'     => $this->inputclient['postcode'],
                    'address'       => $this->inputclient['address'],
                    'province'      => $this->inputclient['province'],
                    'city'          => $this->inputclient['city'],
                ]);
            }
        }else{
            $customer =  Client::create([
                'title'     => $this->inputclient['title'],
                'name'      => $this->inputclient['name'],
                'phone'     => $this->inputclient['phone'],
                'address'   => $this->inputclient['address'],
                'note'      => $this->inputclient['notes'],
                'email'     => $this->user->email,
                'user_id'   => 0,
                'uuid'      => Str::uuid()
            ]);
            $team = Team::find(0);
            $customer->teams()->attach($team);
            if($customer){
                $billing = BillingUser::create([
                    'tax_id'        => $this->inputclient['tax_id'],
                    'name'          => $this->inputclient['name'],
                    'post_code'     => $this->inputclient['postcode'],
                    'address'       => $this->inputclient['address'],
                    'province'      => $this->inputclient['province'],
                    'city'          => $this->inputclient['city'],
                    'user_id'       => $this->user->id
                ]);
            }
        }
        $this->emit('client_saved');
    }

    public function delete()
    {
        dd(1);
    }

    public function render()
    {
        return view('livewire.contact.profile');
    }
}
