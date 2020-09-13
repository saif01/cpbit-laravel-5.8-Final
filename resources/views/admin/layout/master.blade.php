@php
use App\Http\Controllers\UserController;
$Object = new UserController();
$activeUserCount = $Object->ActiveUserCount();
@endphp
<!DOCTYPE html>
<html lang="en" class="loading">
<!-- BEGIN : Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    @include('admin.layout.icon')
    <title>CPB-IT Admin</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,700,900|Montserrat:300,400,500,600,700,800,900" rel="stylesheet">
    <!-- BEGIN VENDOR CSS-->
    <!-- font icons-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/fonts/feather/style.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/fonts/simple-line-icons/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/fonts/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/perfect-scrollbar.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/prism.min.css') }}">
    <!-- END VENDOR CSS-->

    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css/app.min.css') }}">
    <!-- END APEX CSS-->

    <!-- Page CSS-->
    @yield('page-css')

</head>
    <!-- BEGIN : Body-->

<body data-col="2-columns" class=" 2-columns ">
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <div class="wrapper">


        <!-- main menu-->
        <!--.main-menu(class="#{menuColor} #{menuOpenType}", class=(menuShadow == true ? 'menu-shadow' : ''))-->
        <div data-active-color="white" data-background-color="man-of-steel" data-image="{{ asset('admin/app-assets/img/sidebar-bg/01.jpg') }}" class="app-sidebar">
            <!-- main menu header-->
            <!-- Sidebar Header starts-->
            <div class="sidebar-header">
                <div class="logo clearfix"><a href="{{ route('super.dashboard') }}" class="logo-text float-left">
                        <div class="logo-img"><img src="{{ asset('common/logo/cpbit.png') }}" class="rotate logoImg" /></div><span class="text align-middle">Super</span>
                    </a>
                    <a id="sidebarToggle" href="javascript:;" class="nav-toggle d-none d-sm-none d-md-none d-lg-block"><i data-toggle="expanded" class="toggle-icon ft-toggle-right"></i></a><a id="sidebarClose" href="javascript:;" class="nav-close d-block d-md-block d-lg-none d-xl-none"><i class="ft-x"></i></a></div>
            </div>
            <!-- Sidebar Header Ends-->
            <!-- / main menu header-->
            <!-- main menu content-->
            <div class="sidebar-content">
                <div class="nav-container">
                    <ul id="main-menu-navigation" data-menu="menu-navigation" data-scroll-to-active="true" class="navigation navigation-main">

                        <li class="nav-item"><a href="{{ route('super.dashboard') }}"><i class="ft-home"></i><span data-i18n="" class="menu-title">Dashboard</span></a></li>

                        <li class="nav-item"><a href="{{ route('super.maintanance') }}"><i class="ft-alert-triangle red"></i><span data-i18n=""
                                    class="menu-title">Maintenance</span></a></li>

                        <li class="nav-item"><a href="{{ route('user.activity') }}"><i class="ft-activity info"></i><span data-i18n=""
                                    class="menu-title">User Activity</span></a></li>

                        @if (session()->get('admin.admin_cr'))
                            <li class="has-sub nav-item"><a href="#"><i class="fa fa-grav purple"></i><span data-i18n="" class="menu-title">Admin
                                        Section</span></a>
                                <ul class="menu-content">
                                    <li><a href="{{ route('admin.add') }}" class="menu-item"><i class="ft-users text-success"></i> Add Admin</a>
                                    </li>
                                    <li><a href="{{ route('admin.all') }}" class="menu-item"><i class="ft-activity text-info"></i> All Admin</a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        @if (session()->get('admin.user_cr'))
                        <li class="has-sub nav-item"><a href="#"><i class="fa fa-user-circle-o green"></i><span data-i18n="" class="menu-title"> User Section</span></a>
                            <ul class="menu-content">
                                <li><a href="{{ route('user.add') }}" class="menu-item"><i class="ft-users text-success"></i> Add User</a></li>
                                <li><a href="{{ route('user.all') }}" class="menu-item"><i class="ft-activity text-info"></i> All User</a></li>
                            </ul>
                        </li>
                        @endif

                        <!-- Calendar Report Section Section -->
                        <li class="has-sub nav-item"><a href="#"><i class="fa fa-th-list indigo"></i><span data-i18n="" class="menu-title">LogIn Log</span></a>
                            <ul class="menu-content">

                                <li class="nav-item"><a href="{{ route('super.user.login.log') }}"><i class="fa fa-user-circle-o green"></i><span data-i18n="" class="menu-title">User Login Log</span></a>
                                </li>
                                <li class="nav-item"><a href="{{ route('super.user.login.error') }}"><i class="fa fa-user-circle-o pink"></i><span
                                            data-i18n="" class="menu-title">User Login Error</span></a>
                                </li>
                                <li class="nav-item"><a href="{{ route('super.admin.login.log') }}"><i class="fa fa-grav green"></i><span data-i18n="" class="menu-title">Admin Login Log</span></a>
                                </li>
                                <li class="nav-item"><a href="{{ route('super.admin.login.error') }}"><i class="fa fa-grav pink"></i><span
                                            data-i18n="" class="menu-title">Admin Login Error</span></a>
                                </li>

                            </ul>
                        </li>

                        <!-- IT-Connect Section Section -->
                        <li class="has-sub nav-item"><a href="#"><i class="fa fa-comments-o green"></i><span data-i18n="" class="menu-title">iService</span></a>
                            <ul class="menu-content">
                                <li class="nav-item"><a href="{{ route('it.connect.super.operation.all') }}"><i class="fa fa-th-list info"></i><span data-i18n="" class="menu-title">All Operations </span></a>
                                </li>

                                <li class="nav-item"><a href="{{ route('sms.user.super') }}"><i class="fa fa-th-list yellow"></i><span data-i18n="" class="menu-title">User Access</span></a>
                                </li>

                                {{-- <li class="nav-item"><a href="{{ route('sms.report.generate') }}"><i class="fa fa-car yellow"></i><span data-i18n="" class="menu-title">SMS Reports </span></a>
                                </li> --}}

                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('department.all') }}">
                                <i class="fa fa-clone green"></i><span data-i18n="" class="menu-title">All Departments</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('bulocation.all') }}">
                                <i class="fa fa-clone yellow"></i><span data-i18n="" class="menu-title">BU Locations</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('destination.all') }}">
                                <i class="fa fa-clone blue"></i><span data-i18n="" class="menu-title">All Destination</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('topbar.all') }}">
                                <i class="fa fa-clone blue"></i><span data-i18n="" class="menu-title">All Topbars Info.</span>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a href="{{ route('admin.logout') }}"><i class="ft-log-out red"></i><span data-i18n="" class="menu-title">Logout</span></a>
                        </li>

                    </ul>
                </div>
            </div>
            <!-- main menu content-->
            <div class="sidebar-background"></div>
            <!-- main menu footer-->
            <!-- include includes/menu-footer-->
            <!-- main menu footer-->
        </div>
        <!-- / main menu-->


        <!-- Navbar (Header) Starts-->
        <nav class="navbar navbar-expand-lg navbar-light bg-faded header-navbar">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" data-toggle="collapse" class="navbar-toggle d-lg-none float-left"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button><span class="d-lg-none navbar-right navbar-collapse-toggle"><a aria-controls="navbarSupportedContent" href="javascript:;" class="open-navbar-container black"><i class="ft-more-vertical"></i></a></span>
                    <span class="badge gradient-crystal-clear white">{{ session()->get('admin.name') }}</span>
                    @if (session()->get('admin.super') == 1)
                    <span class="badge gradient-pomegranate white ml-1">Act as a Super Admin</span>
                    @endif

                    <span class="badge gradient-green-tea white ml-1" >{{ $activeUserCount }} : Oline User</span>
                </div>
                <div class="navbar-container">
                    <div id="navbarSupportedContent" class="collapse navbar-collapse">

                        <a href="{{ route('admin.dashboard') }}"><button class="btn btn-raised gradient-pomegranate white big-shadow mr-3">Home</button></a>

                        <ul class="navbar-nav">
                            <li class="nav-item mr-2 d-none d-lg-block"><a id="navbar-fullscreen" href="javascript:;" class="nav-link apptogglefullscreen"><i class="ft-maximize font-medium-3 blue-grey darken-4"></i>
                                    <p class="d-none">fullscreen</p>
                                </a></li>


                           <li class="dropdown nav-item"><a id="dropdownBasic3" href="#" data-toggle="dropdown"
                                    class="nav-link position-relative dropdown-toggle">
                                    <img src="{{ asset(Session::get('admin.image')) }}" alt="Admin-img" class="admin-img">
                                </a>
                                <div ngbdropdownmenu="" aria-labelledby="dropdownBasic3" class="dropdown-menu text-left dropdown-menu-right">

                                    <!-- <div class="dropdown-divider"></div> -->
                                    <a href="{{ route('admin.logout') }}" class="dropdown-item"><i
                                            class="ft-power mr-2 text-danger"></i><span>Logout</span></a>
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <!-- Navbar (Header) Ends-->

        <div class="main-panel">
            <!-- BEGIN : Main Content-->
            <div class="main-content">
                <div class="content-wrapper">
                    <!-- Zero configuration table -->

                    @yield('content')


                </div>
            </div>
            <!-- END : End Main Content-->



            <!-- BEGIN : Footer-->
            <footer class="footer footer-static footer-light">
              <p class="clearfix text-muted text-sm-center px-2"><span>Copyright &copy; All rights reserved in CPB-IT.</span></p>
            </footer>
            <!-- End : Footer-->

        </div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->


    <!-- END Notification Sidebar-->



    <!-- BEGIN VENDOR JS-->
    <script src="{{ asset('admin/app-assets/vendors/js/core/jquery-3.2.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/app-assets/vendors/js/core/popper.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/app-assets/vendors/js/core/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/app-assets/vendors/js/perfect-scrollbar.jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/app-assets/vendors/js/prism.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/app-assets/vendors/js/jquery.matchHeight-min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/app-assets/vendors/js/screenfull.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/app-assets/vendors/js/pace/pace.min.js') }}" type="text/javascript"></script>
    <!-- BEGIN VENDOR JS-->

    <!-- BEGIN APEX JS-->
    <script src="{{ asset('admin/app-assets/js/app-sidebar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/app-assets/js/customizer.js') }}" type="text/javascript"></script>
    <!-- END APEX JS-->


    {{-- Tostar + Sweetalert 2 --}}
    <script src="{{ asset('admin/app-assets/custom/sweetalert2/sweetalert2.js') }}" type="text/javascript"></script>
    {{-- Page Js  --}}
    @yield('page-js')

    <script>
        @if(Session::has('messege'))
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
    </script>

</body>
<!-- END : Body   -->


</html>