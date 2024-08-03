<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignSchedule extends Model
{
    use HasFactory;
    protected $table = "campaigns_schedules";
    protected $fillable = [
        'campaign_id',
        'day',
        'time',
        'month',
        'status',
    ];
}
