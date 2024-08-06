<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderUser extends Model
{
    use HasFactory;

    protected $table = 'provider_user';
    protected $fillable = [
        'provider_id',
        'user_id',
        'channel',
        'from',
    ];

    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
