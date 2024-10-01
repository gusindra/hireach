<?php

namespace App\Jobs;

use App\Imports\SkiptraceUpdateImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SkiptraceUpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;
    protected $userId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
        // $this->userId = $userId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Extract file name from file path
        $fileName = basename($this->filePath);
        $file = Storage::disk('ftp')->path($this->filePath);
        // Import the data using SkiptraceUpdateImport
        Excel::import(new SkiptraceUpdateImport($fileName), $file);

        // Optionally, delete the file after processing
        Storage::disk('ftp')->delete($this->filePath);
    }
}
