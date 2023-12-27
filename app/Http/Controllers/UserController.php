<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\UserDetails;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\ImageController;
use App\Http\Requests\ProfileUpdateRequest;

class UserController extends Controller
{

    public function profileUpdate(Request $request)
{ 
    $profile = Auth()->user()->id;

    $this->validate($request, [
        // Your validation 
                'name' => 'required|string',
                'photo' => 'nullable',
                'phone_number' => 'nullable|string',
                'banner' => 'nullable',
                'about' => 'nullable|string',
                'website_link' => 'nullable|string',
                'facebook_link' => 'nullable|string',
                'whatsapp_link' => 'nullable|string',
                'twitter_link' => 'nullable|string',
                'address' => 'nullable|string',
                'location' => 'nullable|string',
                'display' => 'required|in:no,yes',
    ]);

    $data = $request->all();

    // Update the `users` table
    $user = User::findOrFail($profile);

    // Generate a unique slug based on the user's name 
    $slug = Str::slug($request->input('name'));

    // Ensure slug uniqueness
    $count = User::where('slug', $slug)->where('id', '!=', $user->id)->count();

    if ($count > 0) {
        $data['slug'] = $slug . '-' . ($count + 1); // Append a number to make it unique
    } else {
        $data['slug'] = $slug;
    }

    $status = $user->fill($data)->save();

    // Update or create the record in the `user_details` table
    $userDetails = UserDetails::where('user_id', $profile)->first();

    if (!$userDetails) {
        // If the record doesn't exist, create a new instance
        $userDetails = new UserDetails(['user_id' => $profile]);
    }

    $status2 = $userDetails->update($data);

    if ($status && $status2) {
        request()->session()->flash('success', 'Profile Successfully updated');
    } else {
        request()->session()->flash('error', 'Please try again!!');
    }

    return redirect()->route('user-profile');
}

}
