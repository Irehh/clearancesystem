@extends('student.layouts.master')
@section('title','CLEARANCE || DASHBOARD')
@section('main-content')
<div class="container-fluid">
    @include('student.layouts.notification')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Student Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

      <!-- Department -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Department</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            @php
                                $studentId = Auth::user()->id;
                                $departmentStatus = \App\Models\ClearanceRequest::clearanceStatus($studentId, 'department');
                            @endphp
                            
                        </div>
                    </div>
                    <div class="col-auto">
                      @if($departmentStatus == 'approved')
                                <i class="fas fa-check-circle text-success">Cleared</i> 
                            @elseif($departmentStatus == 'rejected')
                                <i class="fas fa-times-circle text-danger">Rejected</i> 
                            @else
                                <i class="fas fa-question-circle text-warning">Pending
                                  @endif</i>
                        {{-- <i class="fas fa-sitemap fa-2x text-gray-300"></i> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
      <!--  -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Faculty</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        @php
                            $studentId = Auth::user()->id;
                            $departmentStatus = \App\Models\ClearanceRequest::clearanceStatus($studentId, 'faculty');
                        @endphp
                        
                    </div>
                </div>
                <div class="col-auto">
                  @if($departmentStatus == 'approved')
                            <i class="fas fa-check-circle text-success">Cleared</i> 
                        @elseif($departmentStatus == 'rejected')
                            <i class="fas fa-times-circle text-danger">Rejected</i> 
                        @else
                            <i class="fas fa-question-circle text-warning">Pending
                              @endif</i>
                    
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
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Alumni</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        @php
                            $studentId = Auth::user()->id;
                            $departmentStatus = \App\Models\ClearanceRequest::clearanceStatus($studentId, 'alumni');
                        @endphp
                        
                    </div>
                </div>
                <div class="col-auto">
                  @if($departmentStatus == 'approved')
                            <i class="fas fa-check-circle text-success">Cleared</i> 
                        @elseif($departmentStatus == 'rejected')
                            <i class="fas fa-times-circle text-danger">Rejected</i> 
                        @else
                            <i class="fas fa-question-circle text-warning">Pending
                              @endif</i>
                    {{-- <i class="fas fa-sitemap fa-2x text-gray-300"></i> --}}
                </div>
            </div>
        </div>
        </div>
      </div>

      <!---->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Security</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        @php
                            $studentId = Auth::user()->id;
                            $departmentStatus = \App\Models\ClearanceRequest::clearanceStatus($studentId, 'security');
                        @endphp
                        
                    </div>
                </div>
                <div class="col-auto">
                  @if($departmentStatus == 'approved')
                            <i class="fas fa-check-circle text-success">Cleared</i> 
                        @elseif($departmentStatus == 'rejected')
                            <i class="fas fa-times-circle text-danger">Rejected</i> 
                        @else
                            <i class="fas fa-question-circle text-warning">Pending
                              @endif</i>
                    {{-- <i class="fas fa-sitemap fa-2x text-gray-300"></i> --}}
                </div>
            </div>
        </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Hostel</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        @php
                            $studentId = Auth::user()->id;
                            $departmentStatus = \App\Models\ClearanceRequest::clearanceStatus($studentId, 'hostel');
                        @endphp
                        
                    </div>
                </div>
                <div class="col-auto">
                  @if($departmentStatus == 'approved')
                            <i class="fas fa-check-circle text-success">Cleared</i> 
                        @elseif($departmentStatus == 'rejected')
                            <i class="fas fa-times-circle text-danger">Rejected</i> 
                        @else
                            <i class="fas fa-question-circle text-warning">Pending
                              @endif</i>
                    {{-- <i class="fas fa-sitemap fa-2x text-gray-300"></i> --}}
                </div>
            </div>
        </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Library</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        @php
                            $studentId = Auth::user()->id;
                            $departmentStatus = \App\Models\ClearanceRequest::clearanceStatus($studentId, 'library');
                        @endphp
                        
                    </div>
                </div>
                <div class="col-auto">
                  @if($departmentStatus == 'approved')
                            <i class="fas fa-check-circle text-success">Cleared</i> 
                        @elseif($departmentStatus == 'rejected')
                            <i class="fas fa-times-circle text-danger">Rejected</i> 
                        @else
                            <i class="fas fa-question-circle text-warning">Pending
                              @endif</i>
                    {{-- <i class="fas fa-sitemap fa-2x text-gray-300"></i> --}}
                </div>
            </div>
        </div>
        </div>
      </div>
    </div>
@endsection