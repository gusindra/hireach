<?php

namespace App\Jobs;

use App\Imports\CellularUpdateValidate;
use App\Imports\CellulerUpdateImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class CellularUpdateValidateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;
    protected $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
        // $this->userId = $userId;
    }

    public function handle()
    {
        $fileName = basename($this->filePath);
        $file = Storage::disk('ftp')->path($this->filePath);
        Excel::import(new CellulerUpdateImport($fileName), $file);
        //Storage::disk('ftp')->delete($this->filePath);
    }
}
