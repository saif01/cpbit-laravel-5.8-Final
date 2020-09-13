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
                    <!--Error page starts-->
                    <section id="error">
                        <div class="container-fluid forgot-password-bg overflow-hidden">
                            <div class="row full-height-vh">
                                <div class="col-12 d-flex align-items-center justify-content-center">
                                    <div class="row">
                                        <div class="col-sm-12 text-center">
                                            <img src="{{ asset('admin/app-assets/img/gallery/error.png') }}" alt=""
                                                class="img-fluid error-img mt-2" height="300" width="500">
                                            <h1 class="text-white mt-4">404 - Page Not Found!</h1>
                                            {{-- <div class="w-75 error-text mx-auto mt-4">
                                                <p class="text-white">paraphonic unassessable foramination Caulopteris
                                                    worral Spirophyton
                                                    encrimson esparcet aggerate chondrule restate whistler shallopy
                                                    biosystematy area
                                                    bertram plotting unstarting quarterstaff.</p>
                                            </div> --}}
                                            <button class="btn btn-primary btn-lg mt-3"><a href="{{ route('user.dashboard') }}"
                                                    class="text-decoration-none text-white">Back
                                                    To Home</a></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!--Error page ends-->

                </div>
            </div>
            <!-- END : End Main Content-->
        </div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->

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

</body>
<!-- END : Body-->

</html>
