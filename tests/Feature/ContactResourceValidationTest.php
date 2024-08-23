<?php

namespace Tests\Feature;

use Tests\TestCase;
use Livewire\Livewire;
use App\Http\Livewire\ValidationResource\AddContact;
use App\Jobs\ProcessSkiptrace;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Queue;

class ContactResourceValidationTest extends TestCase
{
    public function test_file_upload_and_job_dispatch_with_existing_file()
    {
        Storage::fake('local');

        $filePath = storage_path('app/datawiz/contact-sample.xlsx');

        $file = new UploadedFile($filePath, 'validation-sample.xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', null, true);

        Livewire::test(AddContact::class)
            ->set('file', $file)
            ->call('uploadFile');

        $this->assertDatabaseHas('contacts', [
            'type' => 'skip_trace',
            'no_ktp' => '51910910010901910',
        ]);
    }
}
