<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function show($campaign)
    {

        $cmp = Campaign::find($campaign);
        return view('campaign.show', ['campaign' => $cmp]);
    }
}
