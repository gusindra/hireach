<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaldoUser extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'team_id',
        'model_id',
        'model',
        'mutation',
        'description',
        'currency',
        'amount',
        'balance'
    ];

    protected $guarded = [];

    /**
     * Get the flow that belongs to user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the flow that belongs to user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo('App\Models\Team');
    }


    public function provider()
    {
        return $this->belongsTo(Provider::class, 'model_id')->where('model', 'Provider');
    }


    public function request(){
        return $this->belongsTo(Request::class, 'model_id');
    }
    public function blastMessage(){
        return $this->belongsTo(BlastMessage::class, 'model_id');
    }

}
