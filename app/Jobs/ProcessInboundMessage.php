<?php

namespace App\Jobs;

use App\Models\Request;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessInboundMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $request;
    public $prev;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request, $prev)
    {
        $this->request = $request;
        $this->prev = $prev;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //Log::debug($this->request);
        $user_id = $this->prev->user_id;
        $client = $this->prev->client_id ;
        $text = $this->request['text'];

        $data = [
            'source_id' => $this->request['msgid'],
            'reply'     => $text,
            'from'      => $this->request['msisdn'],
            'user_id'   => $user_id,
            'type'      => 'text',
            'client_id' => $client,
            'sent_at'   => Carbon::createFromFormat('Y-m-dH:i:s', $this->request['time']),
            'is_inbound'   => 1,
            'team_id'   => $this->prev->team_id
        ];
        $exsistingMsg = Request::where('from',  $this->request['msisdn'])->where('source_id',  $this->request['msgid'])->where('reply',  $this->request['text'])->where('sent_at', Carbon::createFromFormat('Y-m-dH:i:s',  $this->request['time']))->first();
        if(!$exsistingMsg){
            Request::create($data);
        }
    }
}
