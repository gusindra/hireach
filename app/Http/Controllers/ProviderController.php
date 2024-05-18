<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProviderController extends Controller
{
    public function index()
    {

        return view('provider.provider-table', ['page' => 'provider']);
    }

    public function show(Provider $provider)
    {

        return view('provider.provider-detail', ['provider' => $provider]);
    }
}
