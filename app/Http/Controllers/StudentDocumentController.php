<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Student;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Models\StudentDocument;
use Illuminate\Support\Facades\Storage;

class StudentDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $studentId = auth()->user()->id;
        $document=StudentDocument::orderBy('id','DESC')->where('student_id',$studentId)->paginate(10);
        return view('student.document.index')->with('documents',$document);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create()
    {
        $studentId = auth()->user()->id;
    // Fetch required documents
    $requiredDocuments = Document::all();

    // Pass the required documents and uploaded files to the view
    return view('student.document.create', compact('requiredDocuments'));

    }
    
    public function store(Request $request)
{  
    $data=$request->all();
    // Loop through each document and save it to the database
    foreach ($data['document_id'] as $documentId) {
        StudentDocument::create([
            'student_id' => $data['student_id'],
            'document_id' => $documentId,
            'file_path' => $data['photo']['doc'. $documentId],
        ]);
    }
    request()->session()->flash('success','Document successfully Saved');
    return redirect()->back();
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
        $document=document::findOrFail($id);
        return view('backend.document.edit')->with('document',$document);
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
        $document=document::findOrFail($id);
        $this->validate($request,[
            'title'=>'string|required|max:50',
            'description'=>'string|nullable',
            'photo'=>'string|required',
            'status'=>'required|in:active,inactive',
        ]);
        $data=$request->all();
        // $slug=Str::slug($request->title);
        // $count=document::where('slug',$slug)->count();
        // if($count>0){
        //     $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        // }
        // $data['slug']=$slug;
        // return $slug;
        $status=$document->fill($data)->save();
        if($status){
            request()->session()->flash('success','document successfully updated');
        }
        else{
            request()->session()->flash('error','Error occurred while updating document');
        }
        return redirect()->route('document.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $document=document::findOrFail($id);
        $status=$document->delete();
        if($status){
            request()->session()->flash('success','document successfully deleted');
        }
        else{
            request()->session()->flash('error','Error occurred while deleting document');
        }
        return redirect()->route('document.index');
    }
}
