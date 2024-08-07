<?php

namespace App\Jobs;

use App\Models\BlastMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessSmsStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Log::debug($this->request);
        // if(array_key_exists('msgID',$this->request)){
        //     BlastMessage::where("msg_id", $this->request['msgID'])->where("msisdn", $this->request['msisdn'])->first()->update([
        //         'status' => $this->request['status']
        //     ]);
        // }else{
        //     BlastMessage::where("msg_id", $this->request['msgid'])->where("msisdn", $this->request['msisdn'])->first()->update([
        //         'status' => $this->request['status']
        //     ]);
        // }
        //if(array_key_exists('msgID',$this->request)){
        //    BlastMessage::where("msg_id", $this->request['msgID'])->where("msisdn", $this->request['msisdn'])->first()->update([
        //        'status' => $this->request['status']
        //    ]);
        //}elseif(array_key_exists('msgid',$this->request)){
        //    BlastMessage::where("msg_id", $this->request['msgid'])->where("msisdn", $this->request['msisdn'])->first()->update([
        //        'status' => $this->request['status']
        //    ]);
        //}else{
            Log::debug($this->request);
        //}
        if(array_key_exists("message_status", $this->request)){
            if($this->request['message_status']){
                if($this->request['message_status']==""){
                    $status = "ACCEPTED";
                }else{
                    $status = $this->request['message_status'];
                }
            }
        }
        if(array_key_exists("status", $this->request)){
            if($this->request['status']==""){
                $status = "ACCEPTED";
            }else{
                $status = $this->request['status'];
            }
        }

        if(array_key_exists('msgID',$this->request)){
            $msgid = $this->request['msgID'];
        }elseif((array_key_exists('msgID',$this->request))){
            $msgid = $this->request['msgid'];
        }elseif((array_key_exists('message_id',$this->request))){
            $msgid = $this->request['message_id'];
        }

        $sms = BlastMessage::where("msg_id", $msgid)->where("msisdn", $this->request['msisdn'])->where("status", "!=", $status)->first();
        if($sms){
            $sms->update([
                'status' => $status
            ]);
        }else{
            Log::debug($this->request);
        }
    }
}
