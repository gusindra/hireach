<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\CommerceItem;
use App\Models\Company;
use App\Models\Contract;
use App\Models\Order;
use App\Models\Project;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public $user_info;
    public function __construct()
    {
        // $this->middleware(function ($request, $next) {
        //     // Your auth here
        //     // $this->user_info=Auth::user()->super->first();
        //     // if($this->user_info && $this->user_info->role=='superadmin'){
        //     //     return $next($request);
        //     // }
        //     // abort(404);
        // });
    }

    public function index(Request $request)
    {

        if(empty(auth()->user()->currentTeam)){
            return redirect()->route('teams.create');
        }

        if($request->has('v')){

            $dateS = Carbon::now()->startOfMonth();
            $dateE = Carbon::now()->startOfMonth()->addMonth(1);
            $event = Contract::whereBetween('expired_at',[$dateS,$dateE])->get();

            $arr_event = array();
            $stat = array();

            $stat['client']= Client::where('user_id', auth()->user()->id)->count();
            $stat['project'] = Project::count();
            $stat['order'] = Order::where('user_id', auth()->user()->id)->count();
            $stat['product'] = CommerceItem::where('user_id', auth()->user()->id)->count();

            foreach($event as $key => $ev){
                $arr_event[$key]['title'] = $ev->title;
                $arr_event[$key]['start'] = $ev->expired_at->format('Y-m-d');
                $arr_event[$key]['end'] = $ev->expired_at->format('Y-m-d');
                $arr_event[$key]['className'] = 'bg-gradient-to-tl from-red-600 to-rose-400';
                $arr_event[$key]['url'] = url("/commercial/contract/".$ev->id);
            }

            return view('main-side.dashboard', ['event' => $arr_event, 'stat' => $stat]);
        }else{
            return view('dashboard');
        }



    }

    public function show(Request $request)
    {

        if(empty(auth()->user()->currentTeam)){
            return redirect()->route('teams.create');
        }

        if($request->has('v')){

            $dateS = Carbon::now()->startOfMonth();
            $dateE = Carbon::now()->startOfMonth()->addMonth(1);
            $event = Contract::whereBetween('expired_at',[$dateS,$dateE])->get();

            $arr_event = array();
            $stat = array();

            $stat['client']= Client::where('user_id', auth()->user()->id)->count();
            $stat['project'] = Project::count();
            $stat['order'] = Order::where('user_id', auth()->user()->id)->count();
            $stat['product'] = CommerceItem::where('user_id', auth()->user()->id)->count();

            foreach($event as $key => $ev){
                $arr_event[$key]['title'] = $ev->title;
                $arr_event[$key]['start'] = $ev->expired_at->format('Y-m-d');
                $arr_event[$key]['end'] = $ev->expired_at->format('Y-m-d');
                $arr_event[$key]['className'] = 'bg-gradient-to-tl from-red-600 to-rose-400';
                $arr_event[$key]['url'] = url("/commercial/contract/".$ev->id);
            }

            return view('main-side.dashboard', ['event' => $arr_event, 'stat' => $stat]);
        }else{
            return view('admin');
        }



    }
}
