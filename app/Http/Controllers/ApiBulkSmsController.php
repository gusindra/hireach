<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ProcessSmsApi;
use App\Jobs\ProcessSmsStatus;
use App\Models\ApiCredential;
use App\Models\BlastMessage;
use Illuminate\Support\Facades\Log;

class ApiBulkSmsController extends Controller
{
    public function post(Request $request)
    {
        //get the request & validate parameters
        $fields = $request->validate([
            'type' => 'required|numeric',
            'to' => 'required|string',
            'from' => 'required|alpha_num',
            'text' => 'required|string',
            'servid' => 'required|string',
            'title' => 'required|string',
            'detail' => 'string',
        ]);

        try{
            Log::debug($request->all());
            //$userCredention = ApiCredential::where("user_id", auth()->user()->id)->where("client", "api_sms_mk")->where("is_enabled", 1)->first();
            ProcessSmsApi::dispatch($request->all(), auth()->user());
        }catch(\Exception $e){
            return response()->json([
                'Msg' => "Failed",
                'Status' => 400
            ]);
        }
        // show result on progress
        return response()->json([
            'Msg' => "Successful",
            'Status' => 200
        ]);
    }

    public function status(Request $request)
    {
        //return $request->getContent();
        //Log::debug($request->all());
        ProcessSmsStatus::dispatch($request->all());

        // BlastMessage::where("msg_id", $request->msgID)->where("msisdn", $request->msisdn)->first()->update([
        //     'status' => $request->status
        // ]);

        return response()->json([
            'Msg' => "Process to update",
            'Request' => json_decode($request->getContent(),true),
            'Status' => 200
        ]);
    }
}
