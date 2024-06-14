<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\BlastMessage;
use App\Models\Request;

class ProcessCallBackStatus implements ShouldQueue
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
        //}
        Log::debug($this->request);
        if($this->request['model']=='BlastMessage'){
            if(array_key_exists('msg_id',$this->request)){
                $msgid = $this->request['msg_id'];
            }
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

            $sms = BlastMessage::where("status", "!=", $status);
            if(array_key_exists('id',$this->request)){
                $sms = $sms->where("id", $this->request['id']);
            }elseif(array_key_exists('msgID',$this->request)){
                $sms = $sms->where("msg_id", $msgid);
            }
            if(array_key_exists('msisdn',$this->request)){
                $sms = $sms->where("msisdn", $this->request['msisdn']);
            }
            $sms = $sms->first();
            if($sms){
                $sms->update([
                    'status' => $status
                ]);
                Log::debug("Success update BLAST status:", [$this->request]);
            }else{
                Log::debug("Failed update BLAST status:", [$this->request]);
            }
        }elseif($this->request['model']=='Request'){
            $msgid = $this->request['source_id'];
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

            $sms = Request::where("status", "!=", $status);
            if(array_key_exists('id',$this->request)){
                $sms = $sms->where("id", $this->request['id']);
            }elseif(array_key_exists('source_id',$this->request)){
                $sms = $sms->where("source_id", $msgid);
            }
            $sms = $sms->first();
            if($sms){
                $sms->update([
                    'status' => $status
                ]);
                Log::debug("Success update REQUEST status:", [$this->request]);
            }else{
                Log::debug("Failed update REQUEST status:",$this->request);
            }
        }else{
            Log::debug('No Call Back Status update');
        }
    }
}
