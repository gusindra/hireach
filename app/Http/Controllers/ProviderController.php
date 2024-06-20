<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProviderController extends Controller
{
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

        return view('provider.provider-table', ['page' => 'provider']);
    }

    public function show(Provider $provider)
    {

        return view('provider.provider-detail', ['provider' => $provider]);
    }
}
