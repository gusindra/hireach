<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use Vinkla\Hashids\Facades\Hashids;

class ChatController extends Controller
{
    // public $user_info;
    // public function __construct()
    // {
    //     $this->middleware(function ($request, $next) {
    //         // Your auth here
    //         $granted = false;
    //         $user = auth()->user();
    //         $granted = userAccess('CHAT');

    //         if ($granted) {
    //             return $next($request);
    //         }
    //         abort(403);
    //     });
    // }
    public function index()
    {
        return resource_path('views');
    }

    public function show($slug)
    {
        $team = Team::where('slug', $slug)->first();
        if ($team)
            return view('chat.show', ['team' => $team]);
        abort(404);
    }

    public function chatme(Request $request)
    {
        // $team = Team::where('slug', $request->id)->first();
        $id = Hashids::decode($request->id)[0];
        $team = Team::find($id);
        if ($team)
            return view('chat.chatme', ['team' => $team, 'status' => agentStatus($team->agents)]);
        abort(404);
    }
}
