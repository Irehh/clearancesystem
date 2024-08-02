<?php

namespace App\Http\Controllers;

use App\Models\ClearanceRequest;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     //admin controls this controller
    public function index()
    {
        $users= User::where('role','student')->orderBy('id','ASC')->paginate(10);
        return view('backend.users.index')->with('users',$users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
        [
            'name'=>'string|required|max:30',
            'email'=>'string|required|unique:users',
            'password'=>'string|required',
            'role'=>'required|in:admin,user',
            'status'=>'required|in:active,inactive',
            'photo'=>'nullable|string',
            
        ]);
        // dd($request->all());
        $data=$request->all();
        $data['password']=Hash::make($request->password);
        // dd($data);
        $status=User::create($data);
        // dd($status);
        if($status){
            request()->session()->flash('success','Successfully added user');
        }
        else{
            request()->session()->flash('error','Error occurred while adding user');
        }
        return redirect()->route('users.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user=User::findOrFail($id);
        $student = Student::where('student_id', $user->id)->first();
        return view('backend.users.edit')->with('user',$user)->with('student',$student);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function update(Request $request, $id)
    {
        $user=User::findOrFail($id);
        $this->validate($request,
        [
            'name'=>'string|required|max:30',
            'email'=>'string|required',
            'role'=>'required|in:admin,student,faculty,hostel,alumni,security,department',
            'status'=>'required|in:active,inactive',
            'photo'=>'nullable|string',
            'faculty'=>'nullable|numeric',
            'department'=>'nullable|numeric',
        ]);
        $data=$request->all();
        
        if (isset($data['department'])) {
            $user->department_id = $data['department'];
        }
        if (isset($data['faculty'])) {
            $user->faculty_id = $data['faculty'];
        }
            // Check if the role is being updated to 'student' and the status is being updated to 'active'
        if ($data['role'] === 'student' && $data['status'] === 'active') {
            // Create a student record if the user's role is becoming 'student' and status is becoming 'active'
            
            $student = Student::firstOrCreate(
                ['student_id' => $user->id], // Search condition
                [
                    'first_name' => $data['name'],
                    'registration_number' => $data['regno'],
                    'faculty_id' => $data['faculty'],
                    'department_id' => $data['department'],
                    // Other attributes you want to set for the student
                ]
            );

            if (!$student) {
                request()->session()->flash('error', 'Error occurred while creating student record');
                return redirect()->route('users.index');
            }
        }
        
        $status=$user->fill($data)->save();
        if($status){
            request()->session()->flash('success','Successfully updated');
        }
        else{
            request()->session()->flash('error','Error occured while updating');
        }
        return redirect()->route('users.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete=User::findorFail($id);
        $status=$delete->delete();
        if($status){
            request()->session()->flash('success','User Successfully deleted');
        }
        else{
            request()->session()->flash('error','There is an error while deleting users');
        }
        return redirect()->route('users.index');
    }
}
