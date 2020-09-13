<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>CPB-IT Portal</title>
    <!--=== Favicon ===-->
    @include('user.layout.icon')
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="{{ asset('user/dashboard/assets/css/bootstrap.min.css') }}">
    <!-- Custom styles for this template -->
    <link rel="stylesheet" type="text/css" href="{{ asset('user/dashboard/assets/css/style.min.css') }}">

    <!--*************** Font Awesome v.5.7.0 ****************-->
    <link rel="stylesheet" href="{{ asset('common/fontawesom5.7/css/all.min.css') }}">

    {{-- Preloader --}}
    @include('user.layout.preloader-JS-CSS')

</head>

<body>
<div class="loader">
    <img src="{{ asset('common/preloader/userDashboard.gif') }}" alt="Loading..." />
</div>
    <div class="navbar_grad">
        <!-- Image and text -->
        <nav class="navbar navbar-expand-lg navbar-light resize mx-auto justify-content-center">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('common/logo/cpbit.png') }}" class="nav-logo rotate" alt="CPB-IT">
                <span class="tx-w ml-1">CPB-IT Portal</span>
            </a>
        </nav>
    </div>


    <div class="container" >
        <div class="row justify-content-center">
            @if (session()->get('user.car') == 1)
            <!-- Project Car Pool -->
            <div class="col-md-2 shadow-lg p-3 rounded saif text-center zoom" id="grad1">
                <a href="{{ route('user.carpool.dashboard') }}">
                    <i class="fas fa-car text-primary project-icon"></i>
                    <span class="badge badge-dark project-title">Carpool</span>
                </a>
            </div>
            @endif
            @if (session()->get('user.room') == 1)
            <!--Room Booking Project  -->
            <div class="col-md-2 shadow-lg p-3 rounded saif text-center zoom" id="grad1">
                <a href="{{ route('user.room.dashboard') }}">
                    <i class="fas fa-home text-success project-icon"></i>
                    <span class="badge badge-dark project-title">Room Booking </span>
                </a>
            </div>
            @endif

            @if (session()->get('user.cms') == 1)
                <!--Complaint Management  -->
                <div class="col-md-2 shadow-lg p-3 rounded saif text-center zoom" id="grad1">
                    <a href="{{ route('user.cms.dashboard') }}">

                        <i class="fas fa-laptop-medical project-icon" style="color: #410093 "></i>
                        <span class="badge badge-dark project-title">iHelpDesk</span>
                    </a>
                </div>
            @endif

            @if (session()->get('user.it_connect') == 1)
            <!--Complaint Management  -->
            <div class="col-md-2 shadow-lg p-3 rounded saif text-center zoom" id="grad1">
                <a href="{{ route('user.it.connect.index') }}">
                    <i class="fas fa-plug project-icon" style="color:#9ef02b"></i>
                    <span class="badge badge-dark project-title">iService</span>
                </a>
            </div>
            @endif

            @if (session()->get('user.corona') == 1)
            <!--Complaint Management  -->
            <div class="col-md-2 shadow-lg p-3 rounded saif text-center zoom" id="grad1">
                <a href="{{ route('user.corona.dashboard') }}">
                    <i class="fas fa-temperature-high text-warning project-icon px-3 pb-1" ></i>
                    <span class="badge badge-dark project-title">iTemp</span>
                </a>
            </div>
            @endif

            <!--LogOut  -->
            <div class="col-md-2 shadow-lg p-3 rounded saif text-center zoom" id="grad1">
                <a href="{{ route('user.logout') }}">
                    <i class="fas fa-power-off text-danger project-icon"></i>
                    <span class="badge badge-dark project-title">LogOut</span>
                </a>
            </div>

        </div>

    </div>


    <!-- Footer -->
    <footer class="page-footer font-small footer_grad fixed-bottom">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Powered By CPB-IT</p>
        </div>
    </footer>
    <!-- Footer -->

</body>

</html>
