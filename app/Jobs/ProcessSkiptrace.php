<?php

namespace App\Jobs;

use App\Imports\SkiptraceImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessSkiptrace implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;
    protected $userId;

    /**
     * Create a new job instance.
     *
     * @param string $filePath
     * @param int $userId
     * @return void
     */
    public function __construct($filePath, $userId)
    {
        $this->filePath = $filePath;
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Impor data dari file yang diunggah
        Excel::import(new SkiptraceImport($this->userId), $this->filePath);

        // Tambahkan logika tambahan jika perlu, seperti menghapus file setelah selesai diproses
    }
}
