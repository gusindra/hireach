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
     * test response
     *
     * @param  mixed $request
     * @return void
     */
    public function index(Request $request)
    {
        //return 1;
        //get the request & validate parameters
        $rules = [
            'createDate' => 'required',
            'uniqueTag' => 'required',
            'monitoringDeviceName' => 'required',
            'aiModelId' => 'required',
            'aiModelName' => 'required',
            'alarmDetails' => 'required',
            'image' => 'required',
        ];
        /*$fields = $request->validate($rules);*/
        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages(),
                'code' => 400
            ]);
        }
        //return 2;
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
                $template = Template::where('trigger', $request->uniqueTag)->where('user_id', $customer->user_id)->first();
                if($template){
                    foreach($template->actions as $key => $action){
                        // send request using template prt action
                        $data[$key] = [
                            'channel' => $channel,
                            'provider' => $provider,
                            'to' => $to,
                            'from' => $from,
                            'type' => 0,
                            'title' => $request->alarmDetails,
                            'text' => $this->convertText($request, $action->message),
                            'templateid' => $template->id,
                            'otp' => checkContentOtp($action->message)
                        ];
                        
                        if($request->channel=='email'){
                            $reqArr = json_encode($data);
                            //THIS WILL QUEUE EMAIL JOB
                            //ProcessEmailApi::dispatch($data, $customer->user, $reqArr);
                        }elseif(strpos($request->channel, 'sms') !== false){
                            //ProcessSmsApi::dispatch($data, $customer->user);
                        }elseif($request->channel=='wa'){
                            $credential = null;
                            foreach($customer->user->credential as $cre){
                                if($cre->client=='api_wa_mk'){
                                    $credential = $cre;
                                }
                            }
                            if($credential){
                                //ProcessWaApi::dispatch($data, $credential);
                            }else{
                                return response()->json([
                                    'message' => "Invalid credential",
                                    'code' => 401
                                ]);
                            }
                                
                        }
        
                    }
                    return response()->json([
                        'message' => "Successful",
                        'data' => $data,
                        'code' => 0
                    ]);
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
    
    private function convertText($request, $action){
        $text = $action;
        $variable = [];
        foreach($request->all() as $key => $req){
            $variable[$key] = $req;
        }
        return bind_to_template($variable, $action);
        return $result;
    }
    
    /**
     * post new chat
     *
     * @param  mixed $request
     * @return void
     */
    public function post(Request $request)
    {
        //get the request & validate parameters
        $rules = [
            'createDate' => 'required',
            'uniqueTag' => 'required',
            'monitoringDeviceName' => 'required',
            'aiModelId' => 'required',
            'aiModelName' => 'required',
            'alarmDetails' => 'required',
            'image' => 'required',
        ];
        /*$fields = $request->validate($rules);*/
        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'msg' => $validator->messages(),
                'code' => 400
            ]);
        }

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
                $template = Template::where('trigger', $request->uniqueTag)->where('user_id', $customer->user_id)->first();
                if($template){
                    foreach($template->actions as $key => $action){
                        // send request using template prt action
                        $data[$key] = [
                            'channel' => $channel,
                            'provider' => $provider,
                            'to' => $to,
                            'from' => $from,
                            'type' => 0,
                            'title' => $request->alarmDetails,
                            'text' => $this->convertText($request, $action->message),
                            'templateid' => $template->id,
                            'otp' => checkContentOtp($action->message)
                        ];
    
                        if($channel=='email'){
                            $reqArr = json_encode($data[$key]);
                            //THIS WILL QUEUE EMAIL JOB
                            ProcessEmailApi::dispatch($data[$key], $customer->theUser, $reqArr);
                        }elseif(strpos($channel, 'sms') !== false){
                            ProcessSmsApi::dispatch($data[$key], $customer->theUser);
                        }elseif($channel=='wa'){
                            $credential = null;
                            foreach($customer->theUser->credential as $cre){
                                if($cre->client=='api_wa_mk'){
                                    $credential = $cre;
                                }
                            }
                            if($credential){
                                ProcessWaApi::dispatch($data[$key], $credential);
                            }else{
                                return response()->json([
                                    'msg' => "Invalid credential",
                                    'code' => 401
                                ]);
                            }
                                
                        }
                    }
                    //Return API Respon
                    return response()->json([
                        'msg' => "Successful sending to ".$channel,
                        'data' => $data,
                        'code' => 0
                    ]);
                }else{
                    return response()->json([
                        'msg' => "Template Not Found",
                        'code' => 500
                    ]);
                }
            }elseif(!$customer){
                return response()->json([
                    'msg' => "Phone Number Not Found",
                    'code' => 500
                ]);
            }else{
                return response()->json([
                    'msg' => "Team Chat Not Found",
                    'code' => 500
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'msg' => "Invalid input",
                'code' => 500
            ]);
        }
        // show result on progress
        return response()->json([
            'msg' => "Error! Nothing to save.",
            'code' => 500
        ]);
    }
}
