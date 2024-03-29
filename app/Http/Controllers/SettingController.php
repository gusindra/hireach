<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Auth;

class SettingController extends Controller
{
    public $user_info;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // Your auth here
            $user = auth()->user();

            if($user->super->first()){
                if($user->super->first()->role=='superadmin'){
                    return $next($request);
                }
            }
            if((auth()->user()->activeRole && str_contains(auth()->user()->activeRole->role->name, "Admin"))){
                return $next($request);
            }
            abort(404);
        });
    }

    public function index()
    {
        return view('role.role-table', ['page'=>'role']);
    }

    public function show($page)
    {
        // return $page;
        if($page=="company"){
            return view('settings.company.companies', ['page'=>$page]);
        }
        return view('role.role-detail', ['page'=>$page]);
    }

    public function company(Company $company)
    {
        return view('settings.company.details', ['company'=>$company]);
    }
}
