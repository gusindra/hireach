<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audience extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'user_id'
    ];

    protected $table = 'audience';

    protected $guarded = [];

    protected $appends = ['total_clients'];

    /**
     * audienceClients
     *
     * @return void
     */
    public function audienceClients()
    {
        return $this->hasMany(AudienceClient::class);
    }

    /**
     * lastClient
     *
     * @return void
     */
    public function lastClient()
    {
       return $this->hasOne(AudienceClient::class)->latest();
    }

    /**
     * getTotalClientsAttribute
     *
     * @return void
     */
    public function getTotalClientsAttribute()
    {
        return $this->audienceClients->count();
    }
}
