<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class   Department extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'source_id',
        'name',
        'parent',
        'ancestors',
        'user_id',
        'client_id',
        'server'
    ];

    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo('App\Models\Client', 'client_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function resourcesDepartment()
    {
        return $this->hasMany(DepartmentResource::class);
    }
}
