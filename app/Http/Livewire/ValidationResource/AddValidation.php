<?php

namespace App\Http\Livewire\ValidationResource;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Jobs\ProcessValidation;

class AddValidation extends Component
{
    use WithFileUploads;

    public $file;
    public $storedPath='';
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
                if($p->provider->status){
                    $this->disabled = false;
                }
                if($p->channel!="HR-DST") $this->validationType[$p->channel] = $p->commerceItem->name;
            }
        }
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

        $this->storedPath = $this->file->store('uploads');
        $this->dispatchJob( $this->storedPath);

        $this->closeModal();
        $this->resetFields();

        return redirect(request()->header('Referer'));
    }

    /**
     * dispatchJob
     *
     * @param  mixed $path
     * @return void
     */
    protected function dispatchJob($path)
    {
        ProcessValidation::dispatch($path, $this->type, auth()->id());
    }

    public function render()
    {
        return view('livewire.validation-resource.add-validation');
    }
}
