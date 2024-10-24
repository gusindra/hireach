<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentResource extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'model',
        'model_id',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function blastMessage()
    {
        return $this->belongsTo(BlastMessage::class, 'model_id');
    }

    public function request()
    {
        return $this->belongsTo(Request::class, 'model_id');
    }
}
