@extends('user.layouts.master')

@section('title','Admin Profile')

@section('main-content')

<div class="card shadow mb-4">
    <div class="row">
        <div class="col-md-12">
           @include('backend.layouts.notification')
        </div>
    </div>
   <div class="card-header py-3">
     <h4 class=" font-weight-bold">Profile</h4>
     <ul class="breadcrumbs">
         <li><a href="{{route('user')}}" style="color:#999">Dashboard</a></li>
         <li><a href="" class="active text-primary">Profile Page</a></li>
     </ul>
   </div>
   <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="image">
                        @if($user->photo)
                        <img class="card-img-top img-fluid roundend-circle mt-4" style="border-radius:50%;height:80px;width:80px;margin:auto;" src="{{$user->photo}}" alt="profile picture">
                        @else 
                        <img class="card-img-top img-fluid roundend-circle mt-4" style="border-radius:50%;height:80px;width:80px;margin:auto;" src="{{asset('backend/img/avatar.png')}}" alt="profile picture">
                        @endif
                    </div>
                    <div class="card-body mt-4 ml-2">
                      <h5 class="card-title text-left"><small><i class="fas fa-user"></i> {{$user->name}}</small></h5>
                      <p class="card-text text-left"><small><i class="fas fa-envelope"></i> {{$user->email}}</small></p>
                      <p class="card-text text-left"><small class="text-muted"><i class="fas fa-user-md"></i> {{$user->role}}</small></p>
                      <p class="card-text text-left"><small class="text-muted"><i class="fas fa-building"></i> {{$user->userdetails && $user->userdetails->company_name ? $user->userdetails->company_name : "Set Your Business Name"}}</small></p>
                      <p class="card-text text-left"><small class="text-muted"><i class="fas fa-phone"></i> {{$user->userdetails && $user->userdetails->phone_number ? $user->userdetails->phone_number : "Add phone number"}}</small></p>
                      <p class="card-text text-left"><small class="text-muted"><i class="fas fa-address-card"></i> {{$user->userdetails != null && $user->userdetails->about != null ? $user->userdetails->about : "About"}}</small></p>
                      <p class="card-text text-left"><small class="text-muted"><i class="fas fa-location-arrow"></i> {{$user->userdetails && $user->userdetails->address ? $user->userdetails->address : "Add your address"}}</small></p>
                      <p class="card-text text-left"><small class="text-muted"><i class="fas fa-map-marker"></i> {{$user->userdetails && $user->userdetails->location ? $user->userdetails->location : "Location"}}</small></p>
                      <p class="card-text text-left"><small class="text-muted"><i class="fas fa-link"></i> {{$user->userdetails && $user->userdetails->website_link ? $user->userdetails->website_link : "Website link"}}</small></p>
                      <p class="card-text text-left"><small class="text-muted"><i class="fas fa-link"></i> {{$user->userdetails && $user->userdetails->whatsapp_link ? $user->userdetails->whatsapp_link : "Whatsapp link"}}</small></p>
                      <p class="card-text text-left"><small class="text-muted"><i  class="fa fa-link"></i> {{$user->userdetails && $user->userdetails->facebook_link ? $user->userdetails->facebook_link : "Facebook link"}}</small></p>
                      <p class="card-text text-left"><small class="text-muted"><i class="fas fa-link"></i> {{$user->userdetails && $user->userdetails->twitter_link ? $user->userdetails->twitter_link : "Twitter link"}}</small></p>
                      <p class="card-text text-left"><small class="text-muted"><i class="fas fa-cog"></i> {{$user->userdetails && $user->userdetails->display ? $user->userdetails->display : "no"}}</small></p>
                    </div>
                  </div>
            </div>
            <div class="col-md-8">
                <form class="border px-4 pt-2 pb-3" method="POST" action="{{route('user.profile.update')}}">
                    @csrf
                    <div class="form-group">
                        <label for="inputTitle" class="col-form-label">Name</label>
                      <input id="inputTitle" type="text" name="name" placeholder="Enter name"  value="{{$user->name}}" class="form-control">
                      @error('name')
                      <span class="text-danger">{{$message}}</span>
                      @enderror
                      </div>
              
                      <div class="form-group">
                          <label for="inputEmail" class="col-form-label">Email</label>
                        <input id="inputEmail" disabled type="email" name="email" placeholder="Enter email"  value="{{$user->email}}" class="form-control">
                        @error('email')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                      </div>

                      <div class="form-group">
                        <label for="phone_number" class="col-form-label">Phone Number <span class="text-danger"></span></label>
                        <input type="text" class="form-control" name="phone_number" value="{{$user->userdetails && $user->userdetails->phone_number ? $user->userdetails->phone_number : ""}}">
                        @error('phone_number')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                      </div>

                      <div class="form-group">
                        <label for="location" class="col-form-label">Business Name <span class="text-danger"></span></label>
                        <input type="text" class="form-control" name="company_name" value="{{$user->userdetails && $user->userdetails->company_name ? $user->userdetails->company_name : ""}}">
                        @error('company_name')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                      </div>

                      <div class="form-group">
                        <label for="inputPhoto" class="col-form-label">Photo</label>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                <i class="fa fa-picture-o"></i> Choose
                                </a>
                            </span>
                        <input id="thumbnail" class="form-control" type="text" name="photo" value="{{$user && $user->photo ? $user->photo : ""}}">
                      </div>
                      <div id="holder" style="margin-top:15px;max-height:100px;"></div>
                        @error('photo')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                      </div>

                      <div class="form-group">
                        <label for="inputbanner" class="col-form-label">Banner</label>
                        <div class="input-group">
                          <span class="input-group-btn">
                            <a id="lfm_banner" data-input="thumbnail_banner" data-preview="holder_banner" class="btn btn-primary">
                            <i class="fa fa-picture-o"></i> Choose
                            </a>
                        </span>
                        <input id="thumbnail_banner" class="form-control" type="text" name="banner" value="{{$user->userdetails && $user->userdetails->banner ? $user->userdetails->banner : ""}}">
                      </div>
                      <div id="holder_banner" style="margin-top:15px;max-height:100px;"></div>
                        @error('banner')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                      </div>

                      <div class="form-group">
                        <label for="about" class="col-form-label">Description <span class="text-danger"></span></label>
                        <textarea class="form-control" id="about" name="about">{{$user->userdetails && $user->userdetails->about ? $user->userdetails->about : "" }}</textarea>
                        @error('about')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                      </div>

                      <div class="form-group">
                        <label for="location" class="col-form-label">Address <span class="text-danger"></span></label>
                        <input type="text" class="form-control" name="address" value="{{$user->userdetails && $user->userdetails['address'] ? $user->userdetails['address'] : ""}}">
                        @error('address')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                      </div>

                      <div class="form-group">
                        <label for="location" class="col-form-label">Location <span class="text-danger"></span></label>
                        <input type="text" class="form-control" name="location" value="{{$user->userdetails && $user->userdetails->location ? $user->userdetails->location : ""}}">
                        @error('location')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                      </div>

                      <div class="form-group">
                        <label for="inputTitle" class="col-form-label">Website link</label>
                      <input id="inputTitle" type="text" name="website_link" placeholder="Enter link"  value="{{$user->userdetails && $user->userdetails->website_link ? $user->userdetails->website_link : ""}}" class="form-control">
                      @error('website_link')
                      <span class="text-danger">{{$message}}</span>
                      @enderror
                      </div>

                      <div class="form-group">
                        <label for="inputTitle" class="col-form-label"> Facebook link</label>
                      <input id="inputTitle" type="text" name="facebook_link" placeholder="Enter link"  value="{{$user->userdetails && $user->userdetails->facebook_link ? $user->userdetails->facebook_link : ""}}" class="form-control">
                      @error('facebook_link')
                      <span class="text-danger">{{$message}}</span>
                      @enderror
                      </div>

                      <div class="form-group">
                        <label for="inputTitle" class="col-form-label"> Whatsapp link</label>
                      <input id="inputTitle" type="text" name="whatsapp_link" placeholder="Enter link"  value="{{$user->userdetails && $user->userdetails->whatsapp_link ? $user->userdetails->whatsapp_link : ""}}" class="form-control">
                      @error('whatsapp_link')
                      <span class="text-danger">{{$message}}</span>
                      @enderror
                      </div>

                      <div class="form-group">
                        <label for="inputTitle" class="col-form-label">Twitter link</label>
                      <input id="inputTitle" type="text" name="twitter_link" placeholder="Enter link"  value="{{$user->userdetails && $user->userdetails->twitter_link ? $user->userdetails->twitter_link : ""}}" class="form-control">
                      @error('twitter_link')
                      <span class="text-danger">{{$message}}</span>
                      @enderror
                      </div>
                        {{-- i have issue with this input so its suspended for now --}}

                      <div class="form-group">
                        <label for="display" disabled class="col-form-label">Display Account</label>
                        <select name="display" class="form-control">
                            <option value="no" {{ $user->userdetails && $user->userdetails->display === "no" ? "selected" : "nothing" }}>No</option>
                            <option value="yes" {{ $user->userdetails && $user->userdetails->display === "yes" ? "selected" : "nothing" }} >Yes</option>
                        </select>
                        @error('display')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                      </div>

                        <button type="submit" class="btn btn-success btn-sm">Update</button>
                </form>
            </div>
        </div>
   </div>
</div>

@endsection

<style>
    .breadcrumbs{
        list-style: none;
    }
    .breadcrumbs li{
        float:left;
        margin-right:10px;
    }
    .breadcrumbs li a:hover{
        text-decoration: none;
    }
    .breadcrumbs li .active{
        color:red;
    }
    .breadcrumbs li+li:before{
      content:"/\00a0";
    }
    .image{
        background:url('{{asset('backend/img/background.jpg')}}');
        height:150px;
        background-position:center;
        background-attachment:cover;
        position: relative;
    }
    .image img{
        position: absolute;
        top:55%;
        left:35%;
        margin-top:30%;
    }
    i{
        font-size: 14px;
        padding-right:8px;
    }
  </style> 

@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
    $('#lfm').filemanager('image');
</script>
<script>
  $('#lfm_banner').filemanager('image');
</script>
@endpush