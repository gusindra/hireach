<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public $user_info;
    public function __construct()
    {

        $this->middleware(function ($request, $next) {
            // Your auth here
            $granted = false;
            $user = auth()->user();
            $granted = userAccess('REPORT');

            if ($granted) {
                return $next($request);
            }
            abort(403);
        });
    }


    public function index()
    {
        return view('report.billing');
    }
    public function client()
    {
        return view('report.billing');
    }

    public function show(Request $request, $key)
    {
        if ($request->has('v')) {
            if ($key == 'sms') {
                return view('main-side.report-sms');
            }
        }
        if ($key == 'request') {
            return view('report.request');
        } elseif ($key == 'sms') {
            return view('report.sms_blast');
        } elseif ($key == 'billing') {
            return view('report.billing');
        }
        elseif ($key == 'clients') {
            return view('report.client');
        }
        elseif ($key == 'orders') {
            return view('report.order');
        } elseif ($key == 'logs') {
            return view('report.log-change');
        } elseif ($key == 'assets') {
            return view('report.assets');
        }else {
            return view('report.log');
        }
    }




}
