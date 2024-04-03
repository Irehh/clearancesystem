<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'department_id',
        'faculty_id',
        'message',
        'status',
    ];

    public function student()
    {
        return $this->belongsTo(Students::class);
    }
}
