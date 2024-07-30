<?php

namespace App\Http\Livewire\Audience;

use App\Models\Audience;
use App\Models\BillingUser;
use App\Models\Client;
use App\Models\Team;
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

    /**
     * mount
     *
     * @param  mixed $user
     * @return void
     */
    public function mount($user)
    {
        $this->user;
        $this->inputuser['name'] = $this->user->name ?? '';
        $this->inputuser['description'] = $this->user->description ?? '';
    }

    /**
     * saveUser
     *
     * @param  mixed $id
     * @return void
     */
    public function saveUser($id)
    {
        $user = Audience::find($id);
        $user->update([
            'name' => $this->inputuser['name'],
            'description' => $this->inputuser['description'],
        ]);
        $this->emit('user_saved');
    }

    /**
     * saveClient
     *
     * @return void
     */
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
        $this->authorize('VIEW_RESOURCE', $this->user->user_id);
        return view('livewire.audience.profile');
    }
}
