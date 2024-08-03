<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $this->authorize('VIEW_ANY_CHAT_USR');
        return view('campaign.index');
    }

    /**
     * show
     *
     * @param  mixed $campaign
     * @return void
     */
    public function show($campaign)
    {
        $cmp = Campaign::where('uuid', $campaign)->first();
        return view('campaign.show', ['campaign' => $cmp]);
    }
}
