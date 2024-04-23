<?php

namespace App\Http\Controllers;
use DB;
use Auth;
use Hash;
use Session;
use App\User;
use App\Models\Cart;
use App\Models\Post;
use App\Models\Brand;
use App\Models\Banner;
use App\Models\PostTag;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Spatie\Newsletter\Facades\Newsletter;

class FrontendController extends Controller
{
    public function home(){
        return view('frontend.index');
    } 
    public function index(Request $request){
        return redirect()->route($request->user()->role);
    }
    // Login
    public function login(){
        return view('frontend.pages.login');
    }
    public function loginSubmit(Request $request){
        $data = $request->all();
        
        if(Auth::attempt(['email' => $data['email'], 'password' => $data['password'], 'status' => 'active'])){
            $user = Auth::user();
            // Store user's email in session
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
            return redirect()->back();
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
            'password' => 'required|min:6|confirmed',
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
            return back();
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
