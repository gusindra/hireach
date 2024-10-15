<?php

namespace App\Http\Livewire\ValidationResource;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Jobs\ProcessValidation;

class AddValidation extends Component
{
    use WithFileUploads;

    public $file;
    public $type;
    public $showModal = false;
    public $disabled = true;
    public $validationType = [];

    protected $rules = [
        'file' => 'required|file|mimes:xlsx,xls,csv',
        'type' => 'required',
    ];

    public function mount()
    {
        foreach(auth()->user()->providerUser as $p){
            if($p->provider->name=="Atlasat"){
                $this->disabled = false;
                $this->validationType = $p;
            }
        }
        dd(auth()->user()->providerUser->pluck('channel'));
    }

    public function openModal()
    {
        $this->resetFields();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function resetFields()
    {
        $this->file = null;
        $this->type = '';
    }

    public function uploadFile()
    {
        $this->validate();

        $path = $this->file->store('uploads');
        ProcessValidation::dispatch($path, $this->type, auth()->id());

        $this->closeModal();
        $this->resetFields();

        return redirect(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.validation-resource.add-validation');
    }
}
