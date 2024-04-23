@extends('student.layouts.master')

@section('title','CLEARANCE || Document Create')

@section('main-content')

<div class="card">
    <h5 class="card-header">Add Document</h5>
    <div class="card-body">
      <form method="post" action="{{route('document.store')}}">
        {{csrf_field()}}
        <h6>Course Reg</h6>
        @foreach($requiredDocuments as $document)
          <div class="form-group">
            <div class="input-group">
              <label>{{ $document->name }}</label>
              <input type="hidden" name="student_id" value="{{ Auth()->user()->id }}">
              <input type="hidden" name="document_id[{{ $document->id }}]" value="{{ $document->id }}"> <!-- Use an array for document_id -->
                
                    <span class="input-group-btn">
                        <a id="lfm{{ $document->id }}" data-input="thumbnail{{ $document->id }}" data-preview="holder{{ $document->id }}" class="btn btn-primary">
                        <i class="fa fa-picture-o"></i> Choose
                        </a>
                    </span>
                <input id="thumbnail{{ $document->id }}" class="form-control" type="text" name="photo[{{ 'doc' . $document->id }}]" >
              </div>
              <div id="holder{{ $document->id }}" style="margin-top:15px;max-height:100px;"></div>
                @error('photo'. $document->id)
                <span class="text-danger">{{$message}}</span>
                @enderror
          </div>
        @endforeach
     
        <hr class="my-4">
        <div class="form-group mb-3">
          <button type="reset" class="btn btn-warning">Reset</button>
           <button class="btn btn-success" type="submit">Submit</button>
        </div>
      </form>
    
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script>
 
  $('#lfm1').filemanager('image');
  $('#lfm2').filemanager('image');
  $('#lfm3').filemanager('image');
  $('#lfm4').filemanager('image');
  $('#lfm5').filemanager('image');
  $('#lfm6').filemanager('image');
  $('#lfm7').filemanager('image');
  $('#lfm8').filemanager('image');
  $('#lfm9').filemanager('image');
  $('#lfm10').filemanager('image');
  $('#lfm11').filemanager('image');
  $('#lfm12').filemanager('image');
  $('#lfm13').filemanager('image');
  $('#lfm14').filemanager('image');
  $('#lfm15').filemanager('image');
  $('#lfm16').filemanager('image');
  $('#lfm17').filemanager('image');
  $('#lfm19').filemanager('image');
  $('#lfm20').filemanager('image');
  $('#lfm21').filemanager('image');
  
  
    
   

    $(document).ready(function() {
    $('#description').summernote({
      placeholder: "Write short description.....",
        tabsize: 2,
        height: 150
    });
    });
</script>

@endpush