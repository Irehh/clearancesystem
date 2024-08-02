<?php

namespace App;

use App\Models\Faculty;
use App\Models\Student;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','slug','role','photo','status','provider','provider_id','faculty_id','department_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function clearancerequest(){
        return $this->hasMany('App\Models\ClearanceRequest');
    }

    public function userdetails(){
        return $this->hasOne('App\Models\UserDetails');
    }

    public function student()
    {
        return $this->hasOne(Student::class, 'student_id', 'id');
    }
    public static function getStudent()
    {
        return self::with('student');
        // return Student::with(['student']);
    }
    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public static function getUserBySlug($slug){
        return User::with(['userdetails'])->where('slug',$slug)->where('status', 'active')->first();
    }

    public static function getUserById($id){
        return User::with(['faculty'])->where('id',$id)->where('status', 'active')->first();
    }
    
    
}
