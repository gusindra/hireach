<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AudienceClient extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'audience_id',
        'client_id'
    ];

	protected $table = 'audience_clients';

    protected $guarded = [];

    /**
     * Get this client company is belongs to company.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'uuid');
    }

    /**
     * Get the data company that belongs to company.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function audience()
    {
        return $this->belongsTo('App\Models\Audience', 'audience_id');
    }

}
