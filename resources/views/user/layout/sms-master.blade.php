
<!DOCTYPE html>
<html  >
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <!--=== Favicon ===-->
   @include('user.layout.icon')
  
  <title>CPB-IT.SMS</title>
  <link rel="stylesheet" href="{{ asset('user/sms/assets/web/assets/mobirise-icons/mobirise-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('user/sms/assets/tether/tether.min.css') }}">
  <link rel="stylesheet" href="{{ asset('user/sms/assets/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('user/sms/assets/bootstrap/css/bootstrap-grid.min.css') }}">
  <link rel="stylesheet" href="{{ asset('user/sms/assets/bootstrap/css/bootstrap-reboot.min.css') }}">
  <link rel="stylesheet" href="{{ asset('user/sms/assets/dropdown/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('user/sms/assets/theme/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('user/sms/assets/mobirise/css/mbr-additional.css') }}" type="text/css">

    <!-- Page CSS-->
    @yield('page-css')
  
  <style>
    
    .roundSaif {
    border-radius: 10px;
    border: 2px solid #ffd000;
    padding: 1px;
    width: 50px;
    height: 50px;
      }
      
      .rotate {
        -webkit-transition: -webkit-transform .5s ease-in-out;
        transition: transform .5s ease-in-out;
    }
    .rotate:hover {
        -webkit-transform: rotate(360deg);
        transform: rotate(360deg);
    }

    .r_user {
    border-radius: 50%;
    border: 2px solid 
    #ffd000;
    width: 50px;
    height: 50px;
}
  </style>
  
</head>
<body>
  <section class="menu cid-ruv50guSyY" once="menu" id="menu1-2">

    

    <nav class="navbar navbar-expand beta-menu navbar-dropdown align-items-center navbar-fixed-top navbar-toggleable-sm">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
        </button>
        <div class="menu-logo">
            <div class="navbar-brand">
                
                <span class="navbar-caption-wrap">
                    <a class="navbar-caption text-white display-4" href="{{ route('user.dashboard') }}">
                       <img src="{{ asset('common/logo/cpbit.png') }}" class="roundSaif rotate" alt="CPB-IT">
                    </a></span>
            </div>
        </div>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav nav-dropdown" data-app-modern-menu="true">

                <li class="nav-item">
                <a class="nav-link link text-white display-4" href="{{ route('user.sms.dashboard') }}" aria-expanded="true"> <span class="mbri-home mbr-iconfont mbr-iconfont-btn"></span>
                    Home</a>
                </li>
                
                <li class="nav-item dropdown open">
                    <a class="nav-link link text-white dropdown-toggle display-4" href="#" data-toggle="dropdown-submenu" aria-expanded="true">
                        <img src="{{ asset(Session::get('user.image')) }}" class="img-responsive r_user"
                        alt="Image" />
                    </a>
                    <div class="dropdown-menu">
                    <a class="text-white dropdown-item display-4" href="{{ route('user.sms.profile') }}">My Profile</a>

                    </div>
                </li>
            </ul>

                
            <div class="navbar-buttons mbr-section-btn"><a class="btn btn-sm btn-primary display-4" href="{{ route('user.logout') }}">
                    Logout
                </a></div>
        </div>
    </nav>
</section>
    
    
    

@yield('content')
    
    
<section class="footer2 cid-r7owx7axKc bg-dark" once="footer" id="footer2-e">
    <div class="container">
        <div class="row justify-content-center mbr-white">
            <div class="col-12">
                <p class="mbr-text mb-0 mbr-fonts-style align-center ">
                    &copy; C.P.Bangladesh SMS Management Powered by CPB-IT.
                </p>
            </div>
        </div>
    </div>
</section>


  <script src="{{ asset('user/sms/assets/web/assets/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('user/sms/assets/popper/popper.min.js') }}"></script>
  <script src="{{ asset('user/sms/assets/tether/tether.min.js') }}"></script>
  <script src="{{ asset('user/sms/assets/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('user/sms/assets/smoothscroll/smooth-scroll.js') }}"></script>
  <script src="{{ asset('user/sms/assets/parallax/jarallax.min.js') }}"></script>
  <script src="{{ asset('user/sms/assets/dropdown/js/nav-dropdown.js') }}"></script>
  <script src="{{ asset('user/sms/assets/dropdown/js/navbar-dropdown.js') }}"></script>
  <script src="{{ asset('user/sms/assets/touchswipe/jquery.touch-swipe.min.js') }}"></script>
  <script src="{{ asset('user/sms/assets/theme/js/script.js') }}"></script>
  
   {{--  Page Js  --}}
   @yield('page-js')
  
</body>
</html>