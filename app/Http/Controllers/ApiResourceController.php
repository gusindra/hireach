<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessSkiptrace;
use App\Jobs\ProcessValidation;
use App\Models\ProviderUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiResourceController extends Controller
{
    public $lisType;
    public $disable = false;

    private function checkProvider()
    {
        $provider = ProviderUser::where('user_id', auth()->id())->get();
        foreach($provider as $p){
            if($p->provider->name=="Atlasat"){
                $this->lisType = $provider->pluck('channel');
                return $p->provider->status;
            }
        }
        return false;
    }

    public function skiptrace(Request $request)
    {
        if($this->checkProvider()==0){
            return response()->json(['message' => 'Sorry, Provider is unable to use right now! Please ask Administrator.'], 400);
        }

        $request->validate([
            'contact' => 'required|file|mimes:csv,xlsx,xls',
        ]);

        $path = $request->file('contact')->store('skiptrace_files');

        ProcessSkiptrace::dispatch($path, 'HR-DST', auth()->id());

        return response()->json(['message' => 'Data Import Successfully'], 200);
    }

    public function validation(Request $request)
    {

        if($this->checkProvider()==0){
            return response()->json(['message' => 'Sorry, Provider is unable to use right now! Please ask Administrator.'], 400);
        }

        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:xlsx,xls,csv',
            'type' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $path = $request->file('file')->store('uploads');

        if(in_array($request->type, $this->lisType->toArray())){

            ProcessValidation::dispatch($path, $request->type, $request->user()->id);
            return response()->json(['message' => 'Data Import Successfully'], 200);
        }
        return response()->json(['message' => 'Your account dont have permission to access this type of service'], 400);
    }
}
