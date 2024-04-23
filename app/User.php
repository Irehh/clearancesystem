<?php

namespace App;

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
        'name', 'email', 'password','role','photo','status','provider','provider_id'
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
        return $this->hasMany(Student::class, 'student_id');
    }
    public function getStudent()
    {
        return Student::with(['studentDocuments', 'user'])->first();
    }

    public static function getUserBySlug($slug){
        return User::with(['products','orders','userdetails'])->where('slug',$slug)->where('status', 'active')->first();
    }

    public static function getUserById($id){
        return User::with(['products','orders','userdetails'])->where('id',$id)->where('status', 'active')->first();
    }
    
}
