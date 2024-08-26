<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientValidation extends Model
{
    use HasFactory;
    protected $table = 'client_validations';
    protected $fillable = [
        'contact_id',
        'client_id',
        'user_id',
        'type',
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }
}
