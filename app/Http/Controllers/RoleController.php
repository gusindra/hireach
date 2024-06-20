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
            if (auth()->user()->isSuper || (auth()->user()->team && auth()->user()->team->role == 'superadmin')) {
                return $next($request);
            }
            abort(404);
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
