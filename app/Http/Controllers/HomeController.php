<?php

namespace App\Http\Controllers;

use Hash;
use App\User;
use App\Models\Order;
use App\Models\Category;
use App\Models\PostComment;
use App\Models\UserDetails;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductReview;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\userProfileUpdate;
use App\Http\Controllers\ImageController;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    public function index(){
        return view('student.index');
    }

    public function profile(){
        $id=Auth()->user()->id;
        // return $profile;
        $user = User::getUserById($id);
        return view('user.users.profile')->with("user",$user);
    }


    public function changePassword(){
        return view('user.layouts.userPasswordChange');
    }
    public function changPasswordStore(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);
   
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
   
        return redirect()->route('user')->with('success','Password successfully changed');
    }

    
}
