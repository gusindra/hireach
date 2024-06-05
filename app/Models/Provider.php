<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'company',
        'channel'
    ];

    protected $casts = [
        'code' => 'string',
        'name' => 'string',
    ];

    public function settinProvider()
    {
        return $this->hasMany(SettingProvider::class);
    }
}
