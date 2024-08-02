<?php

namespace App\Models;

use App\Models\Student;
use App\Models\StudentDocument;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
       'id', 'name', 'description'];

       public function studentDocuments()
       {
           return $this->hasMany(StudentDocument::class, 'document_id');
       }
   
       public function user()
       {
           return $this->belongsTo(User::class);
       }

}
