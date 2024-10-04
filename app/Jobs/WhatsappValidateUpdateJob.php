<?php

namespace App\Jobs;

use App\Imports\WaUpdateImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class WhatsappValidateUpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    public function handle()
    {
        $fileName = basename($this->filePath);
        $file = Storage::disk('ftp')->path($this->filePath);
        Excel::import(new WaUpdateImport($fileName), $file);
        //Storage::disk('ftp')->delete($this->filePath);;
    }
}
