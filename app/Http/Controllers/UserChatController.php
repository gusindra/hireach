<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserChatController extends Controller
{
    public function index()
    {


        $this->authorize('VIEW_ANY_CHAT_USR', ['message']);
        return view('message');
    }
}
