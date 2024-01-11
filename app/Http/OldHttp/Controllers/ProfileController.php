<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class ProfileController extends Controller
{
    public $user_info;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // Your auth here
            $permission = false;
            $id = array("PROJECT");
            $permission = checkPermisissions($id);

            if($permission){
                return $next($request);
            }
            abort(404);
        });
    }

    public function index(Request $request)
    {
        if($request->has('v')){
            return view('main-side.profile');
        }
        return redirect()->to("/user/profile");
    }
}
