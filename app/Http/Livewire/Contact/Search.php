<?php

namespace App\Http\Livewire\Contact;

use App\Models\Client;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Search extends Component
{
    use AuthorizesRequests;
    public $modalActionVisible = false;
    public $search;
    public $data = [];
    public $showClients = false;
    public $is_modal = true;

    public function mount($model = null)
    {
        if ($model != null) {
            $this->showClients = true;
        }
    }

    /**
     * updatedTemplateId
     *
     * @param  mixed $value
     * @return void
     */
    public function updatedSearch($value)
    {
        dd(3);
        $client = Client::where('name', 'like', '%' . $value . '%')->orWhere('phone', 'like', '%' . $value . '%')->orWhere('email', 'like', '%' . $value . '%')->limit(5)->get();
        $this->data = $client;
    }

    /**
     * createShowModal
     *
     * @return void
     */
    public function actionShowModal()
    {
        $this->modalActionVisible = true;
    }

    public function render()
    {
        return view('livewire.contact.search');
    }
}
