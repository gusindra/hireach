<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InBoundController extends Controller
{
    public function index()
    {
        return view('dashboard.in-bound');
    }
}
