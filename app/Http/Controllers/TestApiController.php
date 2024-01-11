<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TestApiController extends Controller
{
    public function get(Request $request)
    {
        Log::debug($request->all()); 
        return response()->json([
            'Msg' => "MO telah diterima",
            'Status' => 200
        ]);
        return response()->json([
            'team' => auth()->user(),
            'old' => 'this is get request'
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'old' => $id
        ]);
    }

    public function post(Request $request)
    {
        return response()->json([
            'new' => $request
        ]);
    }

    public function put($id, Request $request)
    {
        return response()->json([
            'old' => $id,
            'new' => $request
        ]);
    }

    public function smsbulk(Request $request)
    {
        $phones = explode (",", $request->to);
        $headers = $request->header('accept');
        if($headers == 'application/json1'){
            $array = [];
            foreach($phones as $key => $phone){
                $array[$key] = [
                    'MsgID' => "TEST".date("YmdHis").rand(1,10),
                    'Msisdn' => $phone,
                    'Status' => "200",
                    'Currency' => "IDR",
                    'Price' => "200"
                ];
            }
            $array[$key+1] = [
                'Balance' => "99.8500",
                'TotalMSISDN' => $key+1
            ];
            
            return response()->json([
                $array
            ]);
        }else{
            // return "400";
            $string = "";
            foreach($phones as $key => $phone){
                // $string = $string.$phone.",".date("YmdHis").rand(1,10).",200,IDR,450|";
                if(count($phones)==1 || count($phones)==$key+1){
                    $string = $string.$phone.",".date("YmdHis").rand(1,10).",200,IDR,450";
                }else{
                    $string = $string.$phone.",".date("YmdHis").rand(1,10).",200,IDR,450|";
                }
            }
            // return $string = $string; //."=99.9500,".$key+1;
            return $string;
        }

        return response()->json([
            'MsgID' => "",
            'Msisdn' => "",
            'Status' => "400"
        ]);
    }
    
    public function message(Request $request)
    {
        Log::debug($request->all()); 
        return response()->json([
            'Msg' => "MO telah diterima",
            'Status' => 200
        ]);
    }
    
    public function status(Request $request)
    {
        Log::debug($request->all()); 
        return response()->json([
            'Msg' => "Status is updated",
            'Status' => 200
        ]);
    }
}
