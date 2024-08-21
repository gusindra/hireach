<?php

namespace App\Http\Livewire\ValidationResource;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Jobs\ProcessSkiptrace;

class AddContact extends Component
{
    use WithFileUploads;

    public $file;
    public $showModal = false;

    protected $rules = [
        'file' => 'required|file|mimes:xlsx,xls,csv',
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
        $this->validate();

        // Store the uploaded file
        $path = $this->file->store('uploads');

        // Dispatch the job to process the file
        ProcessSkiptrace::dispatch($path, auth()->id());

        // Close the modal and reset the form
        $this->closeModal();
        $this->resetFields();

        return redirect(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.validation-resource.add-contact');
    }
}
