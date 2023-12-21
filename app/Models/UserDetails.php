<?php

namespace App\Models;

use App\Http\Middleware\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserDetails extends Model
{
    use HasFactory;
    protected $table = 'user_details';
    protected $fillable = ['phone_number','banner','about','website_link','location','company_name', 'address', 'facebook_link', 'whatsapp_link', 'twitter_link'];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

//     $user = User::find(1);
// $userDetails = $user->userDetails; // This assumes you have defined the relationship in the User model

}
