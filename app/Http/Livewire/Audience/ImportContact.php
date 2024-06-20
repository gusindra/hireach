<?php

namespace App\Http\Livewire\Audience;

use App\Jobs\importAudienceContact;
use App\Jobs\ImportClientsJob;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class ImportContact extends Component
{
    use WithFileUploads;

    public $modalActionVisible = false;
    public $file;
    public $audience;

    public function mount($audience)
    {
        $this->audience = $audience;
    }

    public function actionShowModal()
    {
        $this->resetValidation();
        $this->modalActionVisible = true;
    }

    public function import()
    {
        $this->validate([
            'file' => 'required|file|mimes:csv,xlsx,xls'
        ]);

        $filePath = $this->file->getRealPath();
        $mimeType = $this->file->getClientMimeType();
        $data = [];

        if ($mimeType == 'text/csv') {
            $fileContents = file($filePath);
            foreach ($fileContents as $key => $line) {
                if ($key > 0) {
                    $data[] = str_getcsv($line);
                }
            }
        } else {
            $rows = Excel::toArray([], $filePath)[0];
            foreach ($rows as $key => $row) {
                if ($key > 0) {
                    $data[] = $row;
                }
            }
        }

        importAudienceContact::dispatch($data, $this->audience->id, auth()->user()->id);
        $this->emit('refreshLivewireDatatable');
        $this->modalActionVisible = false;
    }

    public function render()
    {
        return view('livewire.audience.import-contact');
    }
}
