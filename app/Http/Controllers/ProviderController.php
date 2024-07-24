<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProviderController extends Controller
{
    public $user_info;
    public function __construct()
    {

        $this->middleware(function ($request, $next) {
            // Your auth here
            $granted = false;
            $user = auth()->user();
            $granted = userAccess('PROVIDER');

            if ($granted) {
                return $next($request);
            }
            abort(403);
        });
    }



    public function index()
    {

        return view('provider.provider-table', ['page' => 'provider']);
    }

    public function show(Provider $provider)
    {

        return view('provider.provider-detail', ['provider' => $provider]);
    }
}
