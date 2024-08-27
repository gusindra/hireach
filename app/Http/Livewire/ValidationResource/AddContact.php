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

    protected $rules = [
        'file' => 'required|mimes:xlsx,xls,csv',
    ];

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
        // $this->validate();

        $this->storedPath = $this->file->store('uploads');
        $this->dispatchJob( $this->storedPath);

        $this->closeModal();
        $this->resetFields();

        return redirect()->back();
    }

    protected function dispatchJob($path)
    {
        ProcessSkiptrace::dispatch($path, auth()->id());
    }

    public function render()
    {
        return view('livewire.validation-resource.add-contact');
    }
}
