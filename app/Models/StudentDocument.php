<?php

namespace App\Models;

use App\Models\Student;
use App\Models\Document;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentDocument extends Model
{
    use HasFactory;
    protected $table = 'student_documents'; 

    protected $fillable = ['student_id', 'document_id', 'file_path'];

    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public static function getStudentDocuments()
    {
        return static::with(['student', 'document']);
    }



}
