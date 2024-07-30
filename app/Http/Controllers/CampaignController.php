<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index()
    {
        $this->authorize('VIEW_ANY_CHAT_USR');
        return view('campaign.index');
    }

    public function show($campaign)
    {

        $cmp = Campaign::where('uuid', $campaign)->first();
        return view('campaign.show', ['campaign' => $cmp]);
    }
}
