<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\ClearanceRequest;

class DepartmentController extends Controller
{
    //
    public function index(){
        return view('department.index');
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
            ['department' => $clearanceStatus]
        );
    
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Student clearance status updated successfully.');
    }
}
