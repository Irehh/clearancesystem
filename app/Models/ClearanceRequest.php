<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClearanceRequest extends Model
{
    use HasFactory;

    protected $table = 'clearance_requests';

    protected $fillable = [
        'student_id',
        'message',
        'department',
        'faculty',
        'library',
        'alumni',
        // Add more offices as needed
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
