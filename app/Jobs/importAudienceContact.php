<?php

namespace App\Jobs;

use App\Models\Client;
use App\Models\AudienceClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
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
        foreach ($this->data as $row) {
            $exists = Client::where('user_id', $this->userId)->where('phone', $row[1])->count();

            if ($exists == 0) {
                $client = Client::create([
                    'uuid'      => Str::uuid(),
                    'name'      => $row[0],
                    'phone'     => $row[1],
                    'email'     => $row[2],
                    'user_id'   => $this->userId,
                    'created_at' => now()
                ]);

                AudienceClient::create([
                    'audience_id' => $this->audienceId,
                    'client_id'   => $client->uuid
                ]);
            }
        }
    }
}
