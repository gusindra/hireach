<?php

namespace App\Jobs;

use App\Models\CommerceItem;
use App\Imports\PhoneNumberImport;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProcessValidation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;
    protected $type;
    protected $userId;

    /**
     * Create a new job instance.
     *
     * @param string $filePath
     * @param string $type
     * @param int $userId
     * @return void
     */
    public function __construct($filePath, $type, $userId)
    {
        $this->filePath = $filePath;
        $this->type = $type;
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::find($this->userId);
        $price = CommerceItem::where('sku', $this->type)->first();
        // Import data from the uploaded file
        Excel::import(new PhoneNumberImport($this->userId, $this->type, $user, $price->unit_price), $this->filePath);

        // Optional: Delete the file after processing
        Storage::delete($this->filePath);
    }
}
