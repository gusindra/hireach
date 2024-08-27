<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_ktp',
        'status_wa',
        'status_no',
        'type',
        'phone_number',
        'file_name',
        'activation_date',
    ];

    public function clientValidations()
    {
        return $this->hasMany(ClientValidation::class);
    }
}
