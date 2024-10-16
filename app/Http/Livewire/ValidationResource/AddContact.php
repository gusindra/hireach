<?php

namespace App\Http\Livewire\ValidationResource;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Jobs\ProcessSkiptrace;
use Illuminate\Support\Facades\Storage;

class AddContact extends Component
{
    use WithFileUploads;

    public $file;
    public $storedPath='';
    public $showModal = false;
    public $disabled = true;
    public $type;

    protected $rules = [
        'file' => 'required|mimes:xlsx,xls,csv',
    ];

    public function mount()
    {
        foreach(auth()->user()->providerUser as $p){
            if($p->provider->name=="Atlasat" && $p->channel=="HR-DST"){
                if($p->provider->status){
                    $this->disabled = false;
                }
                $this->type = $p->channel;
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
    }

    public function uploadFile()
    {
        $this->validate();

        $this->checkBalance();

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
        ProcessSkiptrace::dispatch($path, $this->type, auth()->id());
    }

    private function checkBalance()
    {
        $this->emit('no_balance');
        // return false;
    }

    public function render()
    {
        return view('livewire.validation-resource.add-contact');
    }
}
