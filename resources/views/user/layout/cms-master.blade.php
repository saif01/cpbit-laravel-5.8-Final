<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--=== Favicon ===-->
    @include('user.layout.icon')
    <title>CPB-IT.CMS</title>
    <!--=== Bootstrap CSS ===-->
    <link href="{{ asset('user/assets/css/4.3/bootstrap.min.css') }}" rel="stylesheet">
    <!--=== Slicknav CSS ===-->
    <link href="{{ asset('user/assets/css/plugins/slicknav.min.css') }}" rel="stylesheet">
    <!--=== Gijgo CSS ===-->
    <link href="{{ asset('user/assets/css/plugins/gijgo.css') }}" rel="stylesheet">
    <!--=== Theme Reset CSS ===-->
    <link href="{{ asset('user/assets/css/reset.css') }}" rel="stylesheet">
    <!--=== Responsive CSS ===-->
    <link href="{{ asset('user/assets/css/responsive.css') }}" rel="stylesheet">
    <!--Font Awesome v.5.7.0 -->
    <link rel="stylesheet" href="{{ asset('user/assets/coustom/fontawesom5.7/css/all.min.css') }}">
    <!--=== Main Style CSS ===-->
    <link href="{{ asset('user/assets/css/main-cms.min.css') }}" rel="stylesheet">

    <!-- Page CSS-->
    @yield('page-css')


</head>

<body class="loader-active">

    <!--== Preloader Area Start ==-->
    <div class="preloader">
        <div class="preloader-spinner">
            <div class="loader-content">
                <img src="{{ asset('user/assets/img/preloader/hard.gif') }}" alt="Syful-IT">
            </div>
        </div>
    </div>
    <!--== Preloader Area End ==-->
    @php
    use \App\Http\Controllers\TopbarController;
    $topObject = new TopbarController();
    $topBarData = $topObject->TopbarData('cms');
    @endphp
    <!--== Header Area Start ==-->
    <header id="header-area" class="fixed-top">
        <!--== Header Top Start ==-->
        <div id="header-top" class="d-none d-xl-block">
            <div class="container">
                <div class="row">
                    <!--== Single HeaderTop Start ==-->
                    <div class="col-lg-4 text-left">
                        <i class="fas fa-map-marker-alt"></i> {{ $topBarData->address }}
                    </div>
                    <!--== Single HeaderTop End ==-->

                    <!--== Single HeaderTop Start ==-->
                    <div class="col-lg-4 text-center">
                        <i class="fas fa-mobile-alt"></i> {{ $topBarData->contact_name }}
                    </div>
                    <!--== Single HeaderTop End ==-->

                    <!--== Single HeaderTop Start ==-->
                    <div class="col-lg-4 text-center">
                        <i class="fas fa-business-time"></i> {{ $topBarData->office_day }} {{ $topBarData->office_time }}
                    </div>
                    <!--== Single HeaderTop End ==-->
                </div>
            </div>
        </div>
        <!--== Header Top End ==-->

        <!--== Header Bottom Start ==-->
        <div id="header-bottom">
            <div class="container">
                <div class="row">
                    <!--== Logo Start ==-->
                    <div class="col-lg-4">
                        <a href="{{ route('user.dashboard') }}" class="logo">
                            <img src="{{ asset('common/logo/cpbit.png') }}" class="roundSaif rotate" alt="CPB-IT">
                        </a>
                    </div>
                    <!--== Logo End ==-->

                    <!--== Main Menu Start ==-->
                    <div class="col-lg-8 d-none d-xl-block">
                        <nav class="mainmenu alignright">
                            <ul>
                                <li class="active"><a href="{{ route('user.cms.dashboard') }}">Home </a>
                                </li>

                                <li>
                                    <a href="#">
                                        <img src="{{ asset(Session::get('user.image')) }}" class="img-responsive r_user"
                                            alt="Image" /> </a>
                                    <ul>
                                        <li><a href="{{ route('user.cms.profile') }}">My Profile</a></li>
                                        <li><a href="{{ route('user.logout') }}"> logout</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="#">History</a>
                                    <ul>
                                        <li><a href="{{ route('user.hard.complain.history') }}">Hardware Complains</a></li>
                                        <li><a href="{{ route('user.app.complain.history') }}">Application Complains</a></li>
                                    </ul>
                                </li>
                                <li><a href="{{ route('user.logout') }}">Log Out</a></li>
                            </ul>
                        </nav>
                    </div>
                    <!--== Main Menu End ==-->
                </div>
            </div>
        </div>
        <!--== Header Bottom End ==-->
    </header>

    @yield('content')

    <!--== Footer Area Start ==-->
    <section id="footer-area">
        <div class="footer-bottom-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <p>Copyright &copy; C.P.Bangladesh CMS Powered by CPB-IT.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--== Footer Area End ==-->

    {{-- <!--== Scroll Top Area Start ==-->
    <div class="scroll-top">
        <img src="{{ asset('user/assets/img/scroll-top.png') }}" alt="Syful-IT">
    </div>
    <!--== Scroll Top Area End ==--> --}}



    <!--=======================Javascript============================-->
    <!--=== Jquery Min Js ===-->
    <script src="{{ asset('user/calendar/lib/jquery.min.js') }}"></script>
    {{-- <script src="{{ asset('user/assets/js/jquery-3.2.1.min.js') }}"></script> --}}
    <!--=== Jquery Migrate Min Js ===-->
    <script src="{{ asset('user/assets/js/jquery-migrate.min.js') }}"></script>
    <!--=== Popper Min Js ===-->
    <script src="{{ asset('user/assets/js/popper.min.js') }}"></script>
    <!--=== Bootstrap Min Js ===-->
    <script src="{{ asset('user/assets/js/bootstrap.min.js') }}"></script>
    <!--=== Slicknav Min Js ===-->
    <script src="{{ asset('user/assets/js/plugins/slicknav.min.js') }}"></script>

    <!--=== Mian Js ===-->
    <script src="{{ asset('user/assets/js/main.js') }}"></script>

    {{-- Tostar + Sweetalert 2 --}}
    <script src="{{ asset('admin/app-assets/custom/sweetalert2/sweetalert2.js') }}" type="text/javascript"></script>

    {{--  Page Js  --}}
    @yield('page-js')

    <script>
        @if (Session::has('messege'))
                Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                icon: "{{ Session::get('alert-type') }}",
                title: "{{ Session::get('title') }}",
                text: "{{ Session::get('messege') }}",
                });
                {{ Session::forget('messege') }}
            @endif

            @if (Session::has('big-title'))
                Swal.fire({
                position: 'center',
                icon: "{{ Session::get('big-alert-type') }}",
                title: "{{ Session::get('big-title') }}",
                showConfirmButton: true,
                timer: 3000,
                timerProgressBar: true,
                });
                {{ Session::forget('big-title') }}
            @endif

    </script>



</body>

</html>
