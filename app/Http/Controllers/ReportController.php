<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    public function index()
    {
        return view('report.billing');
    }

    public function show(Request $request, $key)
    {
        if($request->has('v')){ 
          if($key=='sms'){ 
              return view('main-side.report-sms');
          }
        }
        if($key=='request'){
            return view('report.request');
        }elseif($key=='sms'){
            return view('report.sms_blast');
        }elseif($key=='billing'){
            return view('report.billing');
        }else{
            return view('report.log');
        }
    }
}
