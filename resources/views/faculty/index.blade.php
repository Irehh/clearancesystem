@extends('faculty.layouts.master')

@section('main-content')
<div class="container-fluid">
    @include('faculty.layouts.notification')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Faculty Dashboard</h1>
    </div>

    <!-- Content Row -->

    <div class="row">
      {{-- @php
          use App\Models\StudentDocument;
          // Fetch student documents along with their associated document details
          $studentDocuments = StudentDocument::with(['document', 'student'])->whereIn('document_id', [2, 3])->get()
              ->groupBy('student_id');
      @endphp --}}
         {{-- @php
            use App\Models\StudentDocument;
            // Fetch student documents along with their associated document details
            $studentDocuments = StudentDocument::with(['document', 'student'])
                ->whereIn('document_id', [4, 6,3])
                ->whereHas('student', function($query) {
                    $query->where('faculty_id', 6);
                })
                ->get()
                ->groupBy('student_id');
        @endphp --}}
        @php
    use App\Models\StudentDocument;
    use Illuminate\Support\Facades\Auth;

    // Get the authenticated user's ID
    $userId = Auth::id();

    // Find the associated faculty ID for the authenticated user
    $facultyId = Auth::user()->faculty_id;

    // Fetch student documents along with their associated document details
    $studentDocuments = StudentDocument::with(['document', 'student'])
        ->whereIn('document_id', [2, 3])
        ->whereHas('student', function($query) use ($facultyId) {
            $query->where('faculty_id', $facultyId);
        })
        ->get()
        ->groupBy('student_id');
@endphp
      <!-- Files -->
      @foreach($studentDocuments as $studentId => $documents)
          <div class="col-xl-12 col-lg-12">
              <h4>Student ID: {{ $studentId }}</h4>
              <form method="POST" action="{{ route('faculty.clearance-request.clear', ['student_id' => $studentId]) }}">
                @csrf
                <div class="form-group">
                    <label for="clearance_status">Select Clearance Status:</label>
                    <select class="form-control" id="clearance_status" name="clearance_status">
                        <option value="approved">Approved</option>
                        <option value="pending">Pending</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Clear Student</button>
            </form>
              <table class="table table-bordered" id="order-dataTable" width="100%" cellspacing="0">
                  <thead>
                      <tr>
                          <th>Doc. Id</th>
                          <th>Reg No.</th>
                          <th>Document Name</th>
                          <th>Photo</th>
                          <th>View</th>
                          <th>Status</th>
                          <th>Action</th>
                      </tr>
                  </thead>
                  <tfoot>
                      <tr>
                          <th>Doc. Id</th>
                          <th>Reg No.</th>
                          <th>Document Name</th>
                          <th>Photo</th>
                          <th>View</th>
                          <th>Status</th>
                          <th>Action</th>
                      </tr>
                  </tfoot>
                  <tbody>
                      @foreach($documents as $document) <!-- Iterate over $documents, not $studentDocuments -->
                          <tr>
                              <td>{{ $document->id }}</td>
                              <td>{{ $document->student->registration_number }}</td>
                              <td>{{ $document->document->name }}</td>
                              <td>
                                  @if($document->file_path)
                                      <img src="{{ $document->file_path }}" class="img-fluid rounded-circle" style="max-width:150px" alt="{{ $document->file_path }}">
                                  @else
                                      <img src="{{ asset('backend/img/avatar.png') }}" class="img-fluid rounded-circle" style="max-width:50px" alt="avatar.png">
                                  @endif
                              </td>
                              <td>
                                  <a href="{{ route('faculty.document.show', $document->id) }}" class="btn btn-warning btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="view" data-placement="bottom"><i class="fas fa-eye"></i></a>
                              </td>
                              <td>
                                  @if($document->status == 'active')
                                      <span class="badge badge-success">{{ $document->status }}</span>
                                  @else
                                      <span class="badge badge-danger">{{ $document->status }}</span>
                                  @endif
                              </td>
                              <td>
                                
                                  <form method="POST" action="{{ route('faculty.document.updateStatus', [$document->id]) }}">
                                      @csrf
                                      @method('put')
                                      <button type="submit" class="btn btn-success btn-sm" style="height:30px; width:30px; border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Mark as Active"><i class="fas fa-check"></i></button>
                                  </form>
                                  <form method="POST" action="{{ route('faculty.document.inactiveStatus', [$document->id]) }}">
                                    @csrf
                                    @method('put')
                                    <button type="submit" class="btn btn-danger btn-sm" style="height:30px; width:30px; border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Mark as InActive"><i class="fas fa-times"></i></button>
                                </form>
                                  <form method="POST" action="{{ route('faculty.document.save', [$document->id]) }}">
                                      @csrf
                                      @method('put')
                                      <button type="submit" class="btn btn-primary btn-sm" style="height:30px; width:30px; border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Save Document"><i class="fas fa-save"></i></button>
                                  </form>
                              
                              </td>
                          </tr>
                      @endforeach
                  </tbody>
              </table>
          </div> 
      @endforeach
  </div>
  

  </div>
@endsection