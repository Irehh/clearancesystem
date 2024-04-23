<header class="header shop">
    <!-- Topbar -->
    <div class="topbar">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-12">
                    
                    <!--/ End Top Left -->
                </div>
                <div class="col-lg-6 col-md-12 col-12">
                    <!-- Top Right -->
                    <div class="right-content">
                        <ul class="list-main">
                            @auth 
                            @if(Auth::user()->role == 'student')
                                <li><i class="ti-user"></i> <a href="{{ route('student') }}">Student Dashboard</a></li>
                            @elseif(Auth::user()->role == 'faculty')
                                <li><i class="ti-user"></i> <a href="{{ route('faculty') }}">Faculty Dashboard</a></li>
                            @elseif(Auth::user()->role == 'admin')
                                <li><i class="ti-user"></i> <a href="{{ route('admin') }}">Admin Dashboard</a></li>
                            @elseif(Auth::user()->role == 'security')
                                <li><i class="ti-user"></i> <a href="{{ route('security') }}">Security Dashboard</a></li>
                            @elseif(Auth::user()->role == 'alumni')
                                <li><i class="ti-user"></i> <a href="{{ route('alumni') }}">Alumni Dashboard</a></li>
                            @elseif(Auth::user()->role == 'department')
                                <li><i class="ti-user"></i> <a href="{{ route('department') }}">Department Dashboard</a></li>
                            @else 
                                <li><i class="ti-user"></i> <a href="{{ route('user') }}">Guest Dashboard</a></li> <!-- You can define a 'user' route or use any other default route -->
                            @endif
                            <li><i class="ti-power-off"></i> <a href="{{ route('user.logout') }}">Logout</a></li>
                        @else
                            <li><i class="ti-power-off"></i><a href="{{ route('login.form') }}">Login /</a> <a href="{{ route('register.form') }}">Register</a></li>
                        @endauth
                        </ul>
                    </div>
                    <!-- End Top Right -->
                </div>
            </div>
        </div>
    </div>
 
    <!-- Header Inner -->
    <div class="header-inner">
        <div class="container">
            <div class="cat-nav-head">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ End Header Inner -->
</header>