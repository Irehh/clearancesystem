@extends('faculty.layouts.master')

@section('title','document Detail')

@section('main-content')
<div class="card"> 
  <div class="card-body">
    @if($document)

    <section class="confirmation_part section_padding">
      <div class="document_boxes">
        <div class="card">
          <div class="row no-gutters">
              <div class="col-md-8">
                  <img src="{{ asset($document->file_path) }}" class="card-img" alt="Document Image">
              </div>
              <div class="col-md-4">
                  <div class="card-body">
                      <h5 class="card-title">Document Details</h5>
                      <p class="card-text">Document ID: {{ $document->id }}</p>
                      <p class="card-text">Student ID: {{ $document->student_id }}</p>
                      <p class="card-text">Document Description: {{ $document->description }}</p>
                      <p class="card-text">Status: {{ ucfirst($document->status) }}</p>
                      <p class="card-text">Submitted At: {{ $document->submitted_at }}</p>
                      <a href="{{ asset($document->file_path) }}"  class="btn btn-primary">Download Document</a>
                  </div>
              </div>
          </div>
      </div>
      
      </div>
    </section>
    @endif

  </div>
</div>
@endsection