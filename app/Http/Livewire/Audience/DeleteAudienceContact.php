<?php

namespace App\Http\Livewire\Audience;

use App\Models\AudienceClient;
use Livewire\Component;

class DeleteAudienceContact extends Component
{
    public $audienceClient;
    public $modalDeleteVisible = false;
    public $actionShowDeleteModal = false;

    public function mount($audienceClient)
    {

        $this->audienceClient = $audienceClient;
    }

    public function delete($id)
    {

        $audienceClient = AudienceClient::find($id);
        if ($audienceClient) {
            $audienceClient->delete();
        }
        $this->modalDeleteVisible = false;
        $this->redirect('/audience/' . $audienceClient->audience_id);
    }

    public function actionShowDeleteModal()
    {

        $this->modalDeleteVisible = true;
    }

    public function render()
    {
        return view('livewire.audience.delete-audience-contact');
    }
}
