<?php

namespace App\Http\Controllers;

use App\Models\FlowProcess;
use App\Models\Notice;
use App\Models\Notification;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class ChannelController extends Controller
{
    private function get_channel($key = null)
    {
        $array = ['message' => ['email', 'sms', 'messenger', 'telegram', 'google chat'], 'voice' => ['Robot Call'], 'social' => ['facebook', 'instagram']];
        if (!is_null($key)) {
            return $array[$key];
        }
        return ['message' => ['email', 'sms', 'messenger', 'telegram', 'google chat'], 'voice' => ['Robot Call'], 'social' => ['facebook', 'instagram']];
    }
    public function index()
    {
        return redirect()->route("channel.show", ['message']);
        //return view('channel.index', ['resource'=> $this->get_channel()]);
    }

    public function show($channel, Request $request)
    {
        if ($request->has('rs')) {
            if ($request->rs == 'email') {
            }
            return view('channel.show', ['channel' => $channel, 'resource' => $request->rs, 'list_resource' => $this->get_channel($channel)]);
        }
        return view('channel.index', ['channel' => $channel, 'resource' => $request->rs, 'list_resource' => $this->get_channel($channel)]);
    }

    public function view($channel, $resouce)
    {
        return view('channel.index');
    }
    public function readAll()
    {
        $notification = Notice::where('user_id', auth()->user()->id)->where('status', 'unread')->update([
            'status' => 'read'
        ]);
        return redirect()->back();
    }
}
