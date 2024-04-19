<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentDocument extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'document_id', 'file_path','status','description',];

    public function document()
{
    return $this->belongsTo(Document::class);
}

public function student()
{
    return $this->belongsTo(Students::class);
}
}
