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

        $path = $this->storeFile();

        $this->dispatchJob($path);

        $this->closeModal();
        $this->resetFields();

        return redirect(request()->header('Referer'));
    }

    protected function storeFile()
    {
        return $this->file->store('uploads');
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
