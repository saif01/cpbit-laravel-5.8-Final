{{-- @extends('errors::minimal')

<h1>Error saif</h1>

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('message', __($exception->getMessage() ?: 'Service Unavailable')) --}}

<!DOCTYPE html>
<html lang="en" class="loading">
<!-- BEGIN : Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    @include('admin.layout.icon')
    <title>CPB-IT</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <link
        href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,700,900|Montserrat:300,400,500,600,700,800,900"
        rel="stylesheet">
    <!-- BEGIN VENDOR CSS-->
    <!-- font icons-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/fonts/feather/style.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/fonts/simple-line-icons/style.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin/app-assets/fonts/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/perfect-scrollbar.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/prism.min.css') }}">
    <!-- END VENDOR CSS-->

    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css/app.css') }}">
    <!-- END APEX CSS-->

    <!-- Page CSS-->
    @yield('page-css')

</head>
<!-- END : Head-->

<!-- BEGIN : Body-->

<body data-col="1-column" class=" 1-column  blank-page">
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <div class="wrapper">
        <div class="main-panel">
            <!-- BEGIN : Main Content-->
            <div class="main-content">
                <div class="content-wrapper">
                    <!--Under Maintenance Starts-->
                    <section id="maintenance" class="full-height-vh">
                        <div class="container-fluid">
                            <div class="row full-height-vh">
                                <div class="col-12 d-flex align-items-center justify-content-center">
                                    <div class="row">
                                        <div class="col-sm-12 text-center">
                                            <img src="{{ asset('admin/app-assets/img/gallery/maintenance.png') }}" alt=""
                                                class="img-fluid maintenance-img mt-2" height="300" width="400">
                                            <h1 class="text-danger mt-4">CPB-IT Portal Under Maintenance! </h1>
                                            <div class="w-75 mx-auto maintenance-text mt-3">
                                              <p class="text-white h5">We Are Comming Back Soon..... please take patient</p>
                                            </div>
                                          
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!--Under Maintenance Starts-->

                </div>
            </div>
            <!-- END : End Main Content-->
        </div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->

    {{-- <!-- BEGIN VENDOR JS-->
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
    <!-- END PAGE LEVEL JS--> --}}
</body>
<!-- END : Body-->

</html>
