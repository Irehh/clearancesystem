<?php

namespace App\Http\Controllers;

use Hash;
use App\User;
use Carbon\Carbon;
use App\Models\Student;
use App\Models\Settings;
use Illuminate\Http\Request;
use App\Models\StudentDocument;
use App\Rules\MatchOldPassword;
use App\Models\ClearanceRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Spatie\Activitylog\Models\Activity;

class FacultyController extends Controller
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
        return view('faculty.index');
    }

    public function profile(){
        $id=Auth()->user()->id;
        // return $profile;
        $user = User::getUserById($id);
        return view('faculty.users.profile')->with("user",$user);
    }

    public function clearStudent(Request $request, $student_id)
{
    // Find the student
    $student = Student::findOrFail($student_id);

    // Get the selected clearance status from the form
    $clearanceStatus = $request->input('clearance_status');

    // Create or update the clearance request for the student with the selected status
    $clearanceRequest = ClearanceRequest::updateOrCreate(
        ['student_id' => $student_id],
        ['faculty' => $clearanceStatus]
    );

    // Redirect back with a success message
    return redirect()->back()->with('success', 'Student clearance status updated successfully.');
}

}
