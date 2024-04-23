<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id', 'registration_number'];
    
    public function clearancerequest(){
        return $this->hasMany('App\Models\Document');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function studentDocuments(){
        return $this->hasMany('App\Models\StudentDocument');
    }
}
