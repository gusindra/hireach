<?php

namespace App\Http\Controllers;

use App\Models\Audience;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Vinkla\Hashids\Facades\Hashids;

class ContactController extends Controller
{
    public $user_info;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // Your auth here
            $this->user_info=auth()->user();
            if($this->user_info ){
                return $next($request);
            }
            abort(404);
        });
    }

    public function index(Request $request)
    {
        // if($request->has('v')){
        //     return view('main-side.user');
        // }
        //return view('user.company-table');
        return view('resource.contact');
    }

    public function show(Request $request, $client)
    { 
        $client = Client::where('uuid', $client)->first();
        
        return view('user.contact-profile', ['user'=>$client]);
        // return redirect('user');
    }

    public function audience(Request $request)
    {
        // if($request->has('v')){
        //     return view('main-side.user');
        // }
        //return view('user.company-table');
        return view('resource.audience');
    }

    public function audienceShow(Request $request, $audience)
    { 
        $data = Audience::find($audience);
        
        return view('resource.show-audience', ['user'=>$data]);
        // return redirect('user');
    }

    public function profile(Client $client)
    {
        return view('user.user-profile', ['user'=>$client]);
        // if($client->name != 'Admin'){
        // }
        // return redirect('user');
    }

    public function balance(Client $client, Request $request)
    {
        // if($user->name != 'Admin'){
            return view('user.user-balance', ['user'=>$user, 'team'=>$request->has('team')?$request->team:0]);
        // }
        // return redirect('user');
    }
}
