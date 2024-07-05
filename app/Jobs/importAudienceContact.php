<?php

namespace App\Jobs;

use App\Models\Client;
use App\Models\AudienceClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class importAudienceContact implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $audienceId;
    protected $userId;

    /**
     * Create a new job instance.
     *
     * @param array $data
     * @param int $audienceId
     * @param int $userId
     */
    public function __construct(array $data, int $audienceId, int $userId)
    {
        $this->data = $data;
        $this->audienceId = $audienceId;
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->audienceId) {
            AudienceClient::where('audience_id', $this->audienceId)->delete();
        }

        foreach ($this->data as $row) {

            $client = Client::where('user_id', $this->userId)
                ->where('phone', $row[0])
                ->first();


            if (!$client) {
                $client = Client::create([
                    'uuid'      => Str::uuid(),
                    'phone'     => $row[0],
                    'email'     => $row[1],
                    'name'      => $row[2],
                    'user_id'   => $this->userId,
                    'created_at' => now()
                ]);
            }


            AudienceClient::create([
                'audience_id' => $this->audienceId,
                'client_id'   => $client->uuid,
                'created_at' => now(),
            ]);
        }
    }
}
