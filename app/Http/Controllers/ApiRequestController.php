<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessCallBackStatus;
use Illuminate\Http\Request;
use App\Jobs\ProcessSmsApi;
use App\Jobs\ProcessSmsStatus;
use App\Models\ApiCredential;
use App\Models\BlastMessage;
use Illuminate\Support\Facades\Log;

class ApiRequestController extends Controller
{
    /**
     * post
     *
     * @param  mixed $request
     * @return void
     */
    public function post(Request $request)
    {
        //return $request->url;
        //get the request & validate parameters
        // $fields = $request->validate([
        //     'type' => 'required|numeric',
        //     'to' => 'required|string',
        //     'from' => 'required|alpha_num',
        //     'text' => 'required|string',
        //     'servid' => 'required|string',
        //     'title' => 'required|string',
        //     'detail' => 'string',
        // ]);

        try{
            Log::debug($request->all());
            ProcessSmsApi::dispatch($request->all(), auth()->user());
            //$userCredention = ApiCredential::where("user_id", auth()->user()->id)->where("client", "api_sms_mk")->where("is_enabled", 1)->first();
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

    /**
     * status
     *
     * @param  mixed $request
     * @return void
     */
    public function status(Request $request)
    {
        //return $request->url;
        Log::debug($request->all());
        ProcessSmsStatus::dispatch($request->all());

        // BlastMessage::where("msg_id", $request->msgID)->where("msisdn", $request->msisdn)->first()->update([
        //     'status' => $request->status
        // ]);

        return response()->json([
            'Msg' => "Process to update",
            'Status' => 200
        ]);
    }

    /**
     * logStatus
     *
     * @param  mixed $request
     * @return void
     */
    public function logStatus(Request $request)
    {
        Log::debug($request->all());
        ProcessSmsStatus::dispatch($request->all());

        // BlastMessage::where("msg_id", $request->msgID)->where("msisdn", $request->msisdn)->first()->update([
        //     'status' => $request->status
        // ]);

        return response()->json([
            'Msg' => "Process to update",
            'Status' => 200
        ]);
    }

    /**
     * callBackStatus
     *
     * @param  mixed $request
     * @param  mixed $id
     * @param  mixed $model
     * @return void
     */
    public function callBackStatus(Request $request, $model, $id)
    {
        if($model=='blast'){
            $request->merge([
                'model' => 'BlastMessage',
                'id' => $id
            ]);
            ProcessCallBackStatus::dispatch($request->all());
        }
        if($model=='request'){
            $request->merge([
                'model' => 'Request',
                'id' => $id
            ]);
            ProcessCallBackStatus::dispatch($request->all());
        }

        // BlastMessage::where("msg_id", $request->msgID)->where("msisdn", $request->msisdn)->first()->update([
        //     'status' => $request->status
        // ]);

        return response()->json([
            'Msg' => "Processing to update Blast Status",
            'Status' => 200
        ]);
    }

    public function callBack(Request $request)
    {
        if($request->model=='blast'){
            $request->merge([
                'model' => 'BlastMessage',
                'msg_id' => $request->id
            ]);
            ProcessCallBackStatus::dispatch($request->all());
            // BlastMessage::where("msg_id", $request->msgID)->where("msisdn", $request->msisdn)->first()->update([
            //     'status' => $request->status
            // ]);
        }
        if($request->model=='request'){
            $request->merge([
                'model' => 'Request',
                'source_id' => $request->id
            ]);
            ProcessCallBackStatus::dispatch($request->all());
            // Requet::where("source_id", $request->source_id)->first()->update([
            //     'status' => $request->status
            // ]);
        }


        return response()->json([
            'Msg' => "Process to update Request Status",
            'Status' => 200
        ]);
    }
}
