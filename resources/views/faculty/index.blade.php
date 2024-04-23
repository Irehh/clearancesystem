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

      <!-- Category -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Students</div>
                {{-- <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Category::countActiveCategory()}}</div> --}}
              </div>
              <div class="col-auto">
                <i class="fas fa-sitemap fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Products -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Requests</div>
                {{-- <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Product::countActiveProduct()}}</div> --}}
              </div>
              <div class="col-auto">
                <i class="fas fa-cubes fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Order -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Approved</div>
                <div class="row no-gutters align-items-center">
                  <div class="col-auto">
                    {{-- <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{\App\Models\Order::countActiveOrder()}}</div> --}}
                  </div>
                  
                </div>
              </div>
              <div class="col-auto">
                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!--Posts-->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Post</div>
                {{-- <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Post::countActivePost()}}</div> --}}
              </div>
              <div class="col-auto">
                <i class="fas fa-folder fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Content Row -->

    <div class="row">
      @php
          use App\Models\StudentDocument;
          // Fetch student documents along with their associated document details
          $studentDocuments = StudentDocument::with(['document', 'student'])->whereIn('document_id', [2, 3])->get()
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
                                      <img src="{{ $document->file_path }}" class="img-fluid rounded-circle" style="max-width:50px" alt="{{ $document->file_path }}">
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
                              
                                  <form method="POST" action="{{ route('faculty.document.delete', [$document->id]) }}">
                                      @csrf 
                                      @method('delete')
                                      <button class="btn btn-danger btn-sm dltBtn" data-id="{{ $document->id }}" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
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