<?php

namespace App\Http\Controllers;

use App\Models\Audience;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Str;

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

    public function import(Request $request)
    {
        $file = $request->file('file');
        $fileContents = file($file->getPathname());

        foreach ($fileContents as $key => $line) {
            if($key>0){
                $data = str_getcsv($line);  
                $perData = explode(',', $data[0]);
                //return $perData[1];
                $exsist = Client::where('user_id', auth()->user()->id)->where('phone', $perData[1])->count();     
                if($exsist==0){
                    Client::create([
                        'uuid'      => Str::uuid(),
                        'name' => $perData[0],
                        'phone' => $perData[1],
                        'user_id' => auth()->user()->id,
                        'created_at' => date('Y-m-d H:i:s')
                        // Add more fields as needed
                    ]);
                }     
            }
        }

        return redirect()->back()->with('success', 'CSV file imported successfully.');
    }

    public function export(Request $request)
    {
        $table = Client::where('user_id', auth()->user()->id)->whereDate('created_at', '=', $request->date)->get();
        $filename = "tweets.csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array('name', 'phone', 'created_at'));
    
        foreach($table as $row) {
            fputcsv($handle, array($row['name'], $row['phone'], $row['created_at']));
        }
    
        fclose($handle);
    
        $headers = array(
            'Content-Type' => 'text/csv',
        );
        return Response::download($filename, 'client.csv', $headers);
    }
}
