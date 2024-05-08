<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Povider extends Model
{
    use HasFactory;

     protected $fillable = [
        'code',
        'name',
    ];

    protected $casts = [
        'code' => 'integer',
        'name' => 'string',
    ];
}
