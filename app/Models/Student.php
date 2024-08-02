<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id', 'registration_number','level','first_name', 'last_name','faculty_id', 'department_id'];
    
        public function clearancerequest()
        {
            return $this->hasOne(ClearanceRequest::class);
        }
    
        public function user()
        {
            return $this->belongsTo(User::class, 'student_id');
        }
    
        public function studentDocuments()
        {
            return $this->hasMany(StudentDocument::class, 'student_id');
        }
}
