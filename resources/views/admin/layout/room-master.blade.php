<!DOCTYPE html>
<html lang="en" class="loading">
<!-- BEGIN : Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>CPB-IT Admin</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('admin.layout.icon')
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

    <!-- Tostar css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css/app.css') }}">
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
                <div class="logo clearfix"><a href="{{ route('room.admin.dashboard') }}" class="logo-text float-left">
                        <div class="logo-img"><img src="{{ asset('common/logo/cpbit.png') }}" class="rotate logoImg" /></div><span class="text align-middle">Room</span>
                    </a>
                    <a id="sidebarToggle" href="javascript:;" class="nav-toggle d-none d-sm-none d-md-none d-lg-block"><i data-toggle="expanded" class="toggle-icon ft-toggle-right"></i></a><a id="sidebarClose" href="javascript:;" class="nav-close d-block d-md-block d-lg-none d-xl-none"><i class="ft-x"></i></a></div>
            </div>
            <!-- Sidebar Header Ends-->
            <!-- / main menu header-->
            <!-- main menu content-->
            <div class="sidebar-content">
                <div class="nav-container">
                    <ul id="main-menu-navigation" data-menu="menu-navigation" data-scroll-to-active="true" class="navigation navigation-main">

                        <li class="nav-item"><a href="{{ route('room.admin.dashboard') }}"><i class="ft-home"></i><span data-i18n="" class="menu-title">Dashboard</span></a></li>

                        <div class="dropdown-divider"></div>
                        <li class="nav-item"><a href="{{ route('room.report.calendar') }}"><i class="ft-calendar red"></i><span data-i18n="" class="menu-title">Calendar View</span>
                            </a>
                        </li>



                        <!-- Report Section Section -->
                        <li class="nav-item"><a href="{{ route('room.report.all') }}"><i class="ft-layers yellow"></i><span data-i18n=""
                                    class="menu-title">Report All</span>
                            </a>
                        </li>


                        <li class="has-sub nav-item"><a href="#"><i class="fa fa-home green"></i><span data-i18n="" class="menu-title">Room Section</span></a>
                            <ul class="menu-content">
                                <li><a href="{{ route('room.add') }}" class="menu-item"><i class="ft-user-plus"></i>Add
                                        Room</a></li>
                                <li><a href="{{ route('room.all') }}" class="menu-item"><i class="ft-users text-success"></i>All Room</a></li>
                            </ul>
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
                                        <a href="{{ route('admin.logout') }}" class="dropdown-item"><i class="ft-power mr-2 text-danger"></i><span>Logout</span></a>
                                    </div>
                                </li>

                            </ul>

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
                <p class="clearfix text-muted text-sm-center px-2"><span>Copyright &copy; All rights reserved in CPB-IT.
                    </span></p>
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
    <script src="{{ asset('admin/app-assets/vendors/js/perfect-scrollbar.jquery.min.js') }}" type="text/javascript">
    </script>
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
<!-- END : Body-->

</html>
