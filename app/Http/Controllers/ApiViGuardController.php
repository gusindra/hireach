<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Client;
use App\Models\Template;
use App\Models\Request as ModelsRequest;
use Vinkla\Hashids\Facades\Hashids;
use App\Jobs\ProcessSmsApi;
use App\Jobs\ProcessEmailApi;
use App\Jobs\ProcessWaApi;

class ApiViGuardController extends Controller
{

    /**
     * post new chat
     *
     * @param  mixed $request
     * @return void
     */
    public function post(Request $request)
    {
        //get the request & validate parameters
        $fields = $request->validate([
            'createDate' => 'required|date',
            'uniqueTag' => 'required',
            'monitoringDeviceName' => 'required',
            'aiModelId' => 'required',
            'aiModelName' => 'required',
            'alarmDetails' => 'required',
            'image' => 'required',
        ]);

        try{
            $customer = Client::where('tag', $request->uniqueTag)->first();
            if($customer){
                if($customer->source=='email'){
                    $channel = 'email';
                    $provider = 'provider1';
                    $to = $customer->email;
                    $from = 'alert@hireach.archeeshop.com';
                }else{
                    $channel = 'sms';
                    $provider = 'provider1';
                    $to = $customer->phone;
                    $from = '081339668556';
                }
                $template = Template::where('name', $request->alarmDetails)->where('user_id', $customer->user_id)->first();
                if($template){
                    foreach($template->actions as $key => $action){
                        // send request using template prt action
                        $data = [
                            'channel' => $channel,
                            'provider' => $provider,
                            'to' => $to,
                            'from' => $from,
                            'type' => 0,
                            'title' => $request->alarmDetails,
                            'text' => $action->message,
                            'templateid' => $template->id,
                            'otp' => checkContentOtp($action->message)
                        ];
    
                        if($request->channel=='email'){
                            $reqArr = json_encode($data);
                            //THIS WILL QUEUE EMAIL JOB
                            ProcessEmailApi::dispatch($data, $customer->user, $reqArr);
                        }elseif(strpos($request->channel, 'sms') !== false){
                            ProcessSmsApi::dispatch($data, $customer->user);
                        }elseif($request->channel=='wa'){
                            $credential = null;
                            foreach($customer->user->credential as $cre){
                                if($cre->client=='api_wa_mk'){
                                    $credential = $cre;
                                }
                            }
                            if($credential){
                                ProcessWaApi::dispatch($data, $credential);
                            }else{
                                return response()->json([
                                    'message' => "Invalid credential",
                                    'code' => 401
                                ]);
                            }
                                
                        }
        
                        return response()->json([
                            'msg' => "Successful",
                            'code' => 0
                        ]);
                    }
                }else{
                    return response()->json([
                        'msg' => "Template Not Found",
                        'code' => 400
                    ]);
                }
            }elseif(!$customer){
                return response()->json([
                    'msg' => "Phone Number Not Found",
                    'code' => 400
                ]);
            }else{
                return response()->json([
                    'msg' => "Team Chat Not Found",
                    'code' => 400
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'msg' => "Invalid input",
                'code' => 400
            ]);
        }
        // show result on progress
        return response()->json([
            'msg' => "Error! Nothing to save.",
            'code' => 400
        ]);
    }
}
