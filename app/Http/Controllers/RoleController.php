<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{

    public $user_info;
    public function __construct()
    {

        $this->middleware(function ($request, $next) {
            // Your auth here
            // $granted = false;
            $user = auth()->user();
            $granted = userAccess('ROLE');


            if ($granted) {
                return $next($request);
            }
            abort(403);
        });
    }


    public function index()
    {
        return view('role.role-table', ['page' => 'role']);
    }

    public function show(Role $role)
    {
        return view('role.role-detail', ['role' => $role]);
    }
}
