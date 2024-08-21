<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'no_ktp',
        'status',
        'type',
        'phone_number',
        'activation_date',
    ];

    public function clientValidations()
    {
        return $this->hasMany(ClientValidation::class);
    }
}
