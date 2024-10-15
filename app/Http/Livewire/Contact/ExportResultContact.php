<?php

namespace App\Http\Livewire\Contact;

use Livewire\Component;
use App\Models\Contact;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ContactsExport;

class ExportResultContact extends Component
{
    public $type_input;
    public $file_name;
    public $files = [];
    public $showModal = false;

    protected $rules = [
        'type_input' => 'required',
        'file_name' => 'required',
    ];

    public function render()
    {
        return view('livewire.contact.export-result-contact');
    }

    public function updatedTypeInput($value)
    {
        $allFiles = Contact::where('user_id', auth()->user()->id)->pluck('file_name')->unique()->toArray();
        $this->files = array_filter($allFiles, function($file) use ($value) {
            $pattern = '/' . preg_quote(str_replace('_', '', strtolower($value)), '/') . '/i';
            return preg_match($pattern, str_replace('_', '', strtolower($file))) === 1;
        });
        $this->file_name = '';
    }

    public function export()
    {
        $this->validate();
        return Excel::download(new ContactsExport($this->type_input, $this->file_name), "{$this->file_name}");
    }

    public function showModal()
    {
        $this->showModal = true;
    }

    public function hideModal()
    {
        $this->showModal = false;
    }
}
