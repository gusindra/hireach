<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public $user_info;
    public function __construct()
    {


        $this->middleware(function ($request, $next) {
            // Your auth here
            // $granted = false;
            // $user = auth()->user();
            $granted = userAccess('PERMISSION');

            if ($granted) {
                return $next($request);
            }
            // abort(403);
        });
    }
    public function index()
    {
        return view('permission.index', ['page' => 'permission']);
    }
}
