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
        'channel',
        'status'
    ];

    protected $casts = [
        'code' => 'string',
        'name' => 'string',
    ];

    public function settingProvider()
    {
        return $this->hasMany(SettingProvider::class);
    }

    public function users()
    {
        return $this->hasMany(ProviderUser::class);
    }
}
