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
        'status',
        'type'
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

    public function saldoUsers()
    {
        return $this->hasMany(SaldoUser::class, 'model_id')->where('model', 'Provider');
    }

    public function blastMessages()
    {
        return $this->hasMany(BlastMessage::class, 'provider', 'id');
    }



}
