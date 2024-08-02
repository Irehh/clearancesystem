<?php

namespace App\Http\Controllers;
use DB;
use Hash;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class FrontendController extends Controller
{
    public function home(){
        return view('frontend.index');
    } 
    public function index(Request $request){
        return redirect()->route($request->user()->role);
    }
    public function contact(){
        return view('frontend.pages.contact');
    }
    public function aboutUs(){
        return view('frontend.pages.about-us');
    }
    // Login
    public function login(){
        return view('frontend.pages.login');
    }
    public function loginSubmit(Request $request){
        $data = $request->all();
        
        if(Auth::attempt(['email' => $data['email'], 'password' => $data['password'], 'status' => 'active'])){
            $user = Auth::user();
            //  user's email in session
        Session::put('user', $data['email']);
            
            // Check user role and redirect accordingly
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin');
                case 'faculty':
                    return redirect()->route('faculty');
                case 'department':
                    return redirect()->route('department');
                case 'security':
                    return redirect()->route('security');
                case 'alumni':
                    return redirect()->route('alumni');
                case 'library':
                    return redirect()->route('library');
                case 'hostel':
                    return redirect()->route('hostel');
                default:
                    return redirect()->route('student'); // Or any other default route
            }
        }
        else{
            request()->session()->flash('error','Invalid email and password please try again!');
            return redirect()->route('login.form');
        }
    }
    

    public function logout(){
        Session::forget('user');
        Auth::logout();
        request()->session()->flash('success','Logout successfully');
        return back();
    }

    public function register(){
        return view('frontend.pages.register');
    }

    public function registerSubmit(Request $request)
    {
        $this->validate($request, [
            'name' => 'string|required|min:2',
            'email' => 'string|required|unique:users,email',
            'password' => 'required|min:3|confirmed',
        ]);

        $data = $request->all();
        // Generate a unique slug based on the user's name
        $slug = Str::slug($data['name']);
        // Ensure slug uniqueness
        $count = User::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1); // Append a number to make it unique
        }
        $data['slug'] = $slug; // Add the slug to the data array
        $user = $this->create($data);
        Session::put('user', $data['email']);
        if ($user) {
            request()->session()->flash('success', 'Successfully registered');
            return redirect()->route('home');
        } else {
            request()->session()->flash('error', 'Please try again!');
            return redirect()->route('register.form');
            
        }
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => 'active',
            'slug' => $data['slug'], // Include the slug field
        ]);
    }

    // Reset password
    public function showResetForm(){
        return view('auth.passwords.old-reset');
    }
}
