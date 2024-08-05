<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessCampaignApi;
use App\Jobs\ProcessCampaignSchedule;
use App\Models\Campaign;
use App\Models\CampaignSchedule;
use Carbon\Carbon;
use Twilio\Rest\Trusthub\V1\TrustProducts\TrustProductsEvaluationsPage;

class ScheduleController extends Controller
{

    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $pass = false;
        $count = 0;
        $currentTime = Carbon::now(); // SET GMT di config
        $campaign = Campaign::where('shedule_type', '!=', 'none')->where('status', 'started')->get();

        foreach($campaign as $c){
            $data = [
                'resource' => $c->way_type,
                'type' => $c->type,
                'from' => $c->from,
                'text' => $c->text,
                'title' => $c->title,
                'otp' => $c->otp,
                'provider' => $c->provider,
            ];
            foreach($c->schedule as $s){
                //CHECK MONTH
                if($c->shedule_type=='yearly'){
                    $pass = false;
                    if($s->month == $currentTime->format('m')){
                        if($s->month == $currentTime->format('m')){
                            if($s->day == $currentTime->format('l')){
                                $pass = true;
                            }elseif( $s->day == $currentTime->format('j')){
                                $pass = true;
                            }
                        }
                    }
                }elseif($c->shedule_type=='monhly'){
                    $pass = false;
                    if($s->day == $currentTime->format('l')){
                        $pass = true;
                    }elseif( $s->day == $currentTime->format('j')){
                        $pass = true;
                    }
                }elseif($c->shedule_type=='daily'){
                    $pass = true;
                }
                if($pass){
                    $scheduleDb = explode(':',$s->time);
                    $scheduleNow = explode(':',$currentTime->format('H:i'));
                    if($s->status == 0 && $scheduleDb[0] >= $scheduleNow[0]){
                        $count = $count + 1;
                        if($c->provider=='provider3'){
                            ProcessCampaignApi::dispatch($data, $c->user, $c);
                        }else{
                            ProcessCampaignSchedule::dispatch($c)->delay(now()->addMinutes($scheduleDb[1]));
                        }
                        CampaignSchedule::find($s->id)->update(['status' => 1]);
                    }
                }
            }
        }
        if($count>0)
            return response()->json([
                'code' => 200,
                'message' => "Successful",
                'date' => Carbon::now()->format('d F Y H:i'),
                'total' => $count
            ]);
        return response()->json([
            'code' => 400,
            'message' => "Nothing task is working",
            'date' => Carbon::now()->format('d F Y H:i'),
        ]);
    }

    /**
     * reset
     *
     * @return void
     */
    public function reset(){
        if(CampaignSchedule::where('status', 1)->update(['status' => 0]))
            return response()->json([
                'code' => 200,
                'message' => "Successful Reset",
                'date' => Carbon::now()->format('d F Y H:i')
            ]);
        return response()->json([
            'code' => 400,
            'message' => "Fail Reset",
            'date' => Carbon::now()->format('d F Y H:i'),
        ]);
    }
}

